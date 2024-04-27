<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'manufacturer',
        'model',
        'year',
        'color',
        'plate',
        'type'
    ];

    protected $hidden = [
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute($value): ?string
    {
        return !empty($value) ? date('d/m/Y H:i', strtotime($value)) : null;
    }

    public function getUpdatedAtAttribute($value): ?string
    {
        return !empty($value) ? date('d/m/Y H:i', strtotime($value)) : null;
    }
}
