<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'message',
        'medicine',
        'dosage',
        'reminder_time',
        'start_date',
        'end_date',
        'status',
        'sent',
        'created_by',
    ];

    /**
     * Get the patient associated with the reminder.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the doctor who created the reminder.
     */
    public function createdBy()
    {
        return $this->belongsTo(Doctor::class, 'created_by');
    }
}
