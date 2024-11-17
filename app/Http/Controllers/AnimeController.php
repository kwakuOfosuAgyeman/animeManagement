<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use App\Services\ApiService;
use App\Models\Anime;
use Illuminate\Support\Facades\Log;

class AnimeController extends Controller
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function show($slug): JsonResponse
    {
        if (!preg_match('/^[a-z0-9-]+$/', $slug)) {
            return response()->json([
                'success' => false,
                'error' => 'Invalid slug format.'
            ], 400);
        }
        try {
            $anime = Anime::where('slug', $slug)->first();

            if (!$anime) {
                Log::warning('Anime not found', ['slug' => $slug]);
                return response()->json([
                    'success' => false,
                    'error' => 'Anime not found',
                    'message' => "No anime found with the slug: {$slug}"
                ], 404);
            }

            return response()->json([
                'sucess' => true,
                'data' =>
                    [
                        'mal_id' => $anime->mal_id,
                        'title' => $anime->title,
                        'title_english' => $anime->title_english,
                        'title_japanese' => $anime->title_japanese,
                        'synopsis' => $anime->synopsis,
                        'background' => $anime->background,
                        'episodes' => $anime->episodes,
                        'rating' => $anime->rating,
                        'score' => $anime->score,
                        'scored_by' => $anime->scored_by,
                        'rank' => $anime->rank,
                        'popularity' => $anime->popularity,
                        'members' => $anime->members,
                        'favorites' => $anime->favorites,
                        'image_url' => $anime->image_url,
                        'type' => $anime->type,
                        'source' => $anime->source,
                        'season' => $anime->season,
                        'year' => $anime->year,
                        'genres' => json_decode($anime->genres),
                        'studios' => json_decode($anime->studios),
                    ],
            ]);

        } catch (\Exception $e) {
            Log::error('Unexpected error while fetching anime', [
                'slug' => $slug,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Internal Server Error',
                'message' => 'An unexpected error occurred. Please try again later.'
            ], 500);
        }
    }
}
