<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class expensedetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'BillDate',
        'oprvehiid',
        'head',
        'ExpAmt',
    ];

    protected $casts = [
        'BillDate' => 'datetime',
    ];
}
