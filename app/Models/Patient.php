<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'full_name',
        'age',
        'age_unit',
        'date_of_birth',
        'sex',
        'marital_status',
        'contact_number',
        'email',
        'address',
        'blood_group',
        'id_card_type',
        'id_card_number',
        'nationality',
        'patient_type',
        'province',
        'district',
        'local_level',
        'ward_number',
        'photo',
    ];

    
    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function medicationReminders()
    {
        return $this->hasMany(Reminder::class);
    }

    public function observationVitals()
    {
        return $this->hasOne(ObservationVital::class);
    }
}
