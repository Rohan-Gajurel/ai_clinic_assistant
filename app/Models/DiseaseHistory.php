<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiseaseHistory extends Model
{
    //
    protected $table = 'disease_history';
    protected $fillable = [
        'patient_id',
        'name',
        'duration_value',
        'duration_unit',
        'status',
    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
