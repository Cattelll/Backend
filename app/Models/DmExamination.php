<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DmExamination extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'puskesmas_id',
        'examination_date',
        'examination_type',
        'result',
        'year',
        'month',
        'is_archived',
    ];

    protected $casts = [
        'examination_date' => 'date',
        'result' => 'decimal:2',
        'is_archived' => 'boolean',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function puskesmas(): BelongsTo
    {
        return $this->belongsTo(Puskesmas::class);
    }

    public function isControlled(): bool
    {
        return match($this->examination_type) {
            'hba1c' => $this->result < 7,
            'gdp' => $this->result < 126,
            'gd2jpp' => $this->result < 200,
            'gdsp' => false, // GDSP tidak dihitung untuk terkendali
            default => false,
        };
    }
}