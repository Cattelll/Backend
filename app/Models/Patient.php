<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'puskesmas_id',
        'nik',
        'bpjs_number',
        'name',
        'address',
        'gender',
        'birth_date',
        'age',
        'has_ht',
        'has_dm',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'has_ht' => 'boolean',
        'has_dm' => 'boolean',
    ];

    public function puskesmas(): BelongsTo
    {
        return $this->belongsTo(Puskesmas::class);
    }

    public function htExaminations(): HasMany
    {
        return $this->hasMany(HtExamination::class);
    }

    public function dmExaminations(): HasMany
    {
        return $this->hasMany(DmExamination::class);
    }
}