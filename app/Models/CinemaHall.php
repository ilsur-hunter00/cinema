<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property int $rows
 * @property int $seats_per_row
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class CinemaHall extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'rows',
        'seats_per_row'
    ];

    /**
     * @return HasMany
     */
    public function screenings(): HasMany
    {
        return $this->hasMany(Screening::class);
    }

    /**
     * @return HasMany
     */
    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class);
    }
}
