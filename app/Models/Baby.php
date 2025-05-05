<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Baby extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'birth_date',
        'gender',
        'ethnicity',
        'premature',
        'baby_photo_path'
    ];

    protected $appends = ['photo_url'];

    public function getPhotoUrlAttribute()
    {
        return $this->baby_photo_path ? asset('storage/' . $this->baby_photo_path) : asset('img/default-baby.png');
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->birth_date)->diffInMonths(now());
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
