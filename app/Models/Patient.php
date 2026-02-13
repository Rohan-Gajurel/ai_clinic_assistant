<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'dob',
        'gender',
        'blood_group',
        'disease',
        'allergies',
    ];

    protected $casts = [
        'dob' => 'date',
    ];
}
