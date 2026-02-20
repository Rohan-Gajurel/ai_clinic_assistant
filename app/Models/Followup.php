<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Followup extends Model
{
    //
    protected $fillable = [
        'appointment_id',
        'notes',
        'followup_date',
        'followup_time',
        'status',
    ];  

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
