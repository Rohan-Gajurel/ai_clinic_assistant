<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'doctor_id',
        'days_of_week',
        'start_time',
        'end_time',
        'slot_duration',
        'status',
    ];

    protected $casts = [
        'days_of_week' => 'array',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function generateSlots($date = null)
    {
        $slots = [];
        $start = Carbon::parse($this->start_time);
        $end = Carbon::parse($this->end_time);

        while ($start < $end) {
            $slotEnd = $start->copy()->addMinutes($this->slot_duration);
            if ($slotEnd > $end) {
                break;
            }
            $slots[] = [
                'start_time' => $start->format('H:i'),
                'end_time' => $slotEnd->format('H:i'),
            ];
            $start->addMinutes($this->slot_duration);
        }

        return $slots;
    }

    public function isAvailableOn($date)
    {
        if (empty($this->days_of_week)) {
            return false;
        }
        // stored values are weekday names like 'Monday' etc.
        $dayName = Carbon::parse($date)->format('l');
        return in_array($dayName, $this->days_of_week);
    }

}
