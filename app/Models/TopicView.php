<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicView extends Model
{
    use HasFactory;

    protected $table = 'topic_views';

    protected $fillable = [
        'user_id',
        'topic_id',
        'viewed_at',
    ];

}
