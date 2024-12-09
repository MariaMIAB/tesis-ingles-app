<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'link',
        'status',
        'topic_id',
    ];

    // Relación inversa con Topic
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}


