<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $appends = ['cashout'];

    public function getCashoutAttribute()
    {
        $sum_cashout = 0;
        $records = Records::where('class_id', $this->id)->get();
        foreach ($records as $record) {
            $sum_cashout += round($record->bet * $record->multiplier);
        }
        return $sum_cashout;
    }
}
