<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanceBalance extends Model
{
    use HasFactory;

    protected $fillable = ['gateway', 'balance', 'retrieved_at'];
}
