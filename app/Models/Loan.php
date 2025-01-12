<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'amount',
        'interest_rate',
        'duration',
        'total_payment',
        'status',
        'loan_date',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
