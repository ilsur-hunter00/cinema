<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $duration
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'duration'
    ];

    /**
     * @return HasMany
     */
    public function screenings(): HasMany
    {
        return $this->hasMany(Screening::class);
    }
}
