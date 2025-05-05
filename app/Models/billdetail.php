<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class billdetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'BillNo',
        'CusName',
        'BillDate',
        'CusMobNo',
        'CusAddress',
        'OprName',
        'VehiID',
        'Works',
        'StartTime',
        'EndTime',
        'TotalTime',
        'TotalAmount',
        'Paid',
        'Balance',
    ];

    protected $casts = [
        'BillDate' => 'datetime',
    ];
}
