<?php

namespace App\Models;

use App\Http\Requests\UpdateUniversityRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;

    protected $guarded = [];

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

    public static function patch($id, UpdateUniversityRequest $request)
    {
        $data = [
            'name' => $request->input('name'),
            'website' => $request->input('website'),
            'country_id' => $request->input('country')['id'],
        ];
        if ($id === 0) {
            return self::create($data);
        }

        return self::updateOrCreate(['id' => $id], $data);
    }
}
