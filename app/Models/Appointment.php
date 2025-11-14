<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;
    protected $table = 'appointments';
    protected $primaryKey = 'appointmentID';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'baby_id',
        'appointmentDate',
        'appointmentTime',
        'purpose',
        'status'
    ];
    /**
     * Get the user associated with the appointment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the baby associated with the appointment.
     */
    public function baby()
    {
        return $this->belongsTo(Baby::class);
    }
}
