<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;
    public function agreement(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Agreement::class);

    }
    public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Country::class);

    }
    public function campus(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Campus::class);

    }
}
