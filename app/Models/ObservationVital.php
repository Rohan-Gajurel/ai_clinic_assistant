<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObservationVital extends Model
{
    //
    protected $fillable = [
        'patient_id',
        'blood_pressure',
        'heart_rate',
        'temperature',
        'respiratory_rate',
        'weight',
        'height',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
