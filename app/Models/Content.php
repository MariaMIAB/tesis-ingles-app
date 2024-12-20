<?php

namespace App\Models;

use App\Traits\Trashable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Content extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes, Trashable;

    protected $fillable = [
        'title',
        'body',
        'topic_id',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('content_images');
    }
    
    public function getFirstContentImageUrlAttribute()
    {
        $url = $this->getFirstMediaUrl('content_images');
        $relativePath = parse_url($url, PHP_URL_PATH);
        return $relativePath;
    }
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}

