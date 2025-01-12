<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'amount',
        'type',
        'date',
        'status',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
