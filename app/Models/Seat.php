<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $cinema_hall_id
 * @property string $type
 * @property int $row_number
 * @property int $seat_number
 * @property float $price
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'cinema_hall_id',
        'type',
        'row_number',
        'seat_number',
        'price'
    ];

    /**
     * @return BelongsTo
     */
    public function cinemaHall(): BelongsTo
    {
        return $this->belongsTo(CinemaHall::class);
    }

    /**
     * @return HasMany
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
