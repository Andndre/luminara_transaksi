<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Enums for Business Unit
    const UNIT_PHOTOBOOTH = 'photobooth';
    const UNIT_VISUAL = 'visual';

    protected $casts = [
        'event_date' => 'date',
        'price_total' => 'decimal:2',
        'duration_hours' => 'integer',
    ];

    // Enums for Status
    const STATUS_PENDING = 'PENDING';
    const STATUS_DP_DIBAYAR = 'DP_DIBAYAR';
    const STATUS_LUNAS = 'LUNAS';
    const STATUS_DIBATALKAN = 'DIBATALKAN';
}