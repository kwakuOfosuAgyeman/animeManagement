<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anime extends Model
{
    protected $fillable =
    [
        'mal_id',
        'slug',
        'title',
        'title_english',
        'title_japanese',
        'synopsis',
        'image_url',
        'type',
        'source',
        'episodes',
        'status',
        'duration',
        'rating',
        'score',
        'scored_by',
        'rank',
        'popularity',
        'members',
        'favorites',
        'background',
        'season',
        'year',
        'genres',
        'studios'
    ];
}
