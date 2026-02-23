<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DrugHistory extends Model
{
    protected $table = 'drug_history';

    protected $fillable = [
        'patient_id',
        'drug_name',
        'drug_dose',
        'drug_frequency',
        'drug_for',
        'dose_unit',
        'status',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
