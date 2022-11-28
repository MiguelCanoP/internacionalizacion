<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgreementType extends Model
{
    use HasFactory;
    public function agreement(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Agreement::class);
    }
}
