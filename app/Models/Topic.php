<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_name',
        'topic_description',
        'quarter_id',
    ];

    /*public function quarter()
    {
        return $this->belongsTo(Quarter::class);
    }*/
}
