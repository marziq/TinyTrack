<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccination extends Model
{
    use HasFactory;

    protected $fillable = [
        'baby_id',
        'vaccine_name',
        'scheduled_date',
        'administered_at',
        'status'
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'administered_at' => 'datetime',
    ];

    public function baby()
    {
        return $this->belongsTo(Baby::class);
    }
}
