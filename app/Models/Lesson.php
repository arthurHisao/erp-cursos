<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'video_name',
        'video_link_name',
        'video_description',
        'video_path',
        'video_thumbnail',    
        'user_name',
        'category'
    ];
}
