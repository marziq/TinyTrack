<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteTip extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tip_id',
        'title',
        'content',
        'category',
        'rich_content',
        'image_url',
        'video_url'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
