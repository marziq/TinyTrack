<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Milestone extends Model
{
    use HasFactory;

    protected $table = 'milestones';
    protected $primaryKey = 'milestoneID';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'baby_id',
        'title',
        'description',
        'achievedDate',
    ];

    public function baby()
    {
        return $this->belongsTo(Baby::class);
    }
}
