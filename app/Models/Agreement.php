<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    use HasFactory;
    public function program(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(program::class);
    }

    public function University(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(University::class);
    }
    public function agreementType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AgreementType::class);
    }
}
