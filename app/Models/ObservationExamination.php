<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObservationExamination extends Model
{
    //
    protected $fillable = [
        'patient_id',
        'primary_symptom',
        'other_symptoms',
        'symptom_duration_value',
        'symptom_duration_unit',
    ];
}
