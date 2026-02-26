<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillItem extends Model
{
    protected $fillable = [
        'bill_id',
        'service_name',
        'quantity',
        'rate',
        'amount',
        'discount',
        'net_amount',
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
