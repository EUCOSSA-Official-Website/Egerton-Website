<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MpesaC2BTransaction extends Model
{
    use HasFactory;

    protected $table = 'mpesa_c2b_transactions';

    protected $fillable = [
        'trans_id',
        'transaction_type',
        'trans_time',
        'trans_amount',
        'business_short_code',
        'bill_ref_number',
        'org_account_balance',
        'msisdn',
        'first_name',
        'middle_name',
        'last_name',
    ];

    protected $casts = [
        'trans_time' => 'datetime',
        'trans_amount' => 'decimal:2',
        'org_account_balance' => 'decimal:2',
    ];

    protected $appends = ['full_name'];

    public function getFullNameAttribute(): string
    {
        return trim(implode(' ', array_filter([
            $this->first_name,
            $this->middle_name,
            $this->last_name,
        ]))) ?: 'Unknown';
    }
}
