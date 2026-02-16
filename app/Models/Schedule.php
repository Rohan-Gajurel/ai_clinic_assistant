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

        $carbon = Carbon::parse($date);
        $dayFull = strtolower($carbon->format('l')); // monday
        $dayShort = strtolower($carbon->format('D')); // Mon
        $dayNumN = (int) $carbon->format('N'); // 1 (Mon) - 7 (Sun)
        $dayNum0 = (int) $carbon->dayOfWeek; // 0 (Sun) - 6 (Sat)

        foreach ($this->days_of_week as $d) {
            if (is_null($d) || $d === '') continue;
            if (is_numeric($d)) {
                $n = (int) $d;
                if ($n === $dayNumN || $n === $dayNum0) return true;
                continue;
            }
            $val = strtolower(trim($d));
            if ($val === $dayFull || $val === strtolower(substr($dayFull,0,3)) || $val === strtolower($dayShort)) {
                return true;
            }
        }

        return false;
    }

}
