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
 * @property int $movie_id
 * @property Carbon $start_time
 * @property Carbon $end_time
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Screening extends Model
{
    use HasFactory;

    protected $fillable = [
        'cinema_hall_id',
        'movie_id',
        'start_time',
        'end_time'
    ];

    /**
     * @return BelongsTo
     */
    public function cinemaHall(): BelongsTo
    {
        return $this->belongsTo(CinemaHall::class);
    }

    /**
     * @return BelongsTo
     */
    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    /**
     * @return HasMany
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
