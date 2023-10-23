<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $screening_id
 * @property int $seat_id
 * @property int $user_id
 * @property string $booking_code
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'screening_id',
        'seat_id',
        'user_id',
        'booking_code'
    ];

    /**
     * @return BelongsTo
     */
    public function screening(): BelongsTo
    {
        return $this->belongsTo(Screening::class);
    }

    /**
     * @return BelongsTo
     */
    public function seat(): BelongsTo
    {
        return $this->belongsTo(Seat::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
