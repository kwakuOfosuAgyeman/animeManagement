<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Anime;
use App\Services\ApiService;
use Illuminate\Support\Facades\Log;

class AnimeList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:anime-list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and store 100 most popular anime';

    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        parent::__construct();
        $this->apiService = $apiService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $allAnimes = [];
        $page = 1;
        $limit = 25;
        try {
            while(count($allAnimes) < 100) {
                $this->info("Fetching page {$page}...");
                // Fetching the anime data
                $response = $this->apiService->fetchData('top/anime', ['limit' => 25, 'page' => $page]);
                $animes = $response['data'] ?? [];

                if (empty($animes)) {
                    $this->error('No anime data found.');
                    Log::warning('No anime data returned from API');
                    return;
                }
                $allAnimes = array_merge($allAnimes, $animes);
                if(count($allAnimes) >= 100){
                    break;
                }
                $page++;
                sleep(1 / 3); //Ensures max 3 attempts per second
            }


            // Loop through each anime and update or create
            foreach ($allAnimes as $anime) {
                $sanitizedAnime = $this->sanitizeAnimeData($anime);
                try {
                    Anime::updateOrCreate(
                        ['mal_id' => $anime['mal_id']],
                        $sanitizedAnime
                    );
                } catch (\Exception $e) {
                    Log::error('Error importing anime data', [
                        'mal_id' => $anime['mal_id'],
                        'title' => $anime['title'],
                        'error_message' => $e->getMessage(),
                    ]);
                }
            }

            $this->info('Anime data imported successfully!');
            Log::info('Anime data imported successfully', ['count' => count($animes)]);

        } catch (\Exception $e) {
            $this->error('An error occurred while importing anime data.');
            Log::error('Anime import failed', ['error_message' => $e->getMessage()]);
        }
    }

    protected function generateUniqueSlug($title)
    {
        $slug = \Str::slug($title);
        $count = Anime::where('slug', 'like', "{$slug}%")->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }

    private function sanitizeAnimeData(array $anime): array
    {
        return [
            'slug' => $this->generateUniqueSlug(trim(strip_tags($anime['title']))),
            'title' => trim(strip_tags($anime['title'])),
            'title_english' => isset($anime['title_english']) ? trim(strip_tags($anime['title_english'])) : null,
            'title_japanese' => isset($anime['title_japanese']) ? trim(strip_tags($anime['title_japanese'])) : null,
            'synopsis' => isset($anime['synopsis']) ? trim(strip_tags($anime['synopsis'])) : null,
            'background' => isset($anime['background']) ? trim(strip_tags($anime['background'])) : null,
            'episodes' => isset($anime['episodes']) ? intval($anime['episodes']) : null,
            'rating' => isset($anime['rating']) ? trim(strip_tags($anime['rating'])) : null,
            'score' => isset($anime['score']) ? floatval($anime['score']) : null,
            'scored_by' => isset($anime['scored_by']) ? intval($anime['scored_by']) : null,
            'rank' => isset($anime['rank']) ? intval($anime['rank']) : null,
            'popularity' => isset($anime['popularity']) ? intval($anime['popularity']) : null,
            'members' => isset($anime['members']) ? intval($anime['members']) : null,
            'favorites' => isset($anime['favorites']) ? intval($anime['favorites']) : null,
            'image_url' => isset($anime['images']['jpg']['image_url'])
                ? filter_var($anime['images']['jpg']['image_url'], FILTER_VALIDATE_URL)
                : null,
            'type' => isset($anime['type']) ? trim(strip_tags($anime['type'])) : null,
            'source' => isset($anime['source']) ? trim(strip_tags($anime['source'])) : null,
            'season' => isset($anime['season']) ? trim(strip_tags($anime['season'])) : null,
            'year' => isset($anime['year']) ? intval($anime['year']) : null,
            'genres' => isset($anime['genres']) ? json_encode(array_map(function ($genre) {
                return [
                    'id' => intval($genre['mal_id'] ?? 0),
                    'name' => trim(strip_tags($genre['name'] ?? '')),
                ];
            }, $anime['genres'])) : '[]',
            'studios' => isset($anime['studios']) ? json_encode(array_map(function ($studio) {
                return [
                    'id' => intval($studio['mal_id'] ?? 0),
                    'name' => trim(strip_tags($studio['name'] ?? '')),
                ];
            }, $anime['studios'])) : '[]',
        ];
    }

}

