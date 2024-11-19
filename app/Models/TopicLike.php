<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicLike extends Model
{
    use HasFactory;

    protected $table = 'topic_likes';

    protected $fillable = [
        'user_id',
        'topic_id',
        'liked_at',
    ];

}
