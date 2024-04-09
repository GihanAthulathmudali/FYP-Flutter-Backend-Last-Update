<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    use HasFactory;
    protected $table = 'disease';
    protected $fillable = [
        'disease_name',
        'crop_name',
        'description',
        'solution',
        'image_paths',
    ];

    protected $casts = [
        'image_paths' => 'array', // Cast image paths to array
    ];
}
