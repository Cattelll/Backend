<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Puskesmas extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function patients(): HasMany
    {
        return $this->hasMany(Patient::class);
    }

    public function htExaminations(): HasMany
    {
        return $this->hasMany(HtExamination::class);
    }

    public function dmExaminations(): HasMany
    {
        return $this->hasMany(DmExamination::class);
    }

    public function yearlyTargets(): HasMany
    {
        return $this->hasMany(YearlyTarget::class);
    }
}
