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

    public function growths()
    {
        return $this->hasMany(Growth::class);
    }

    public function milestones()
    {
        return $this->hasMany(Milestone::class, 'baby_id', 'id');
    }

    public function vaccinations()
    {
        return $this->hasMany(Vaccination::class, 'baby_id', 'id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'baby_id', 'id');
    }
}
