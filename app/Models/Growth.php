<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Growth extends Model
{
    use HasFactory;

    protected $table = 'growths';
    protected $primaryKey = 'growthID';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'baby_id',
        'growthMonth',
        'height',
        'weight',
        'head_circumference',
    ];

    public function baby()
    {
        return $this->belongsTo(Baby::class);
    }
}
