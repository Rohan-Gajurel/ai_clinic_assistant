<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'rating',
        'review',
        'would_recommend',
    ];

    protected $casts = [
        'would_recommend' => 'boolean',
    ];

    protected $table= 'feedbacks';

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
