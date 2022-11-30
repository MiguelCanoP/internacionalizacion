<?php

namespace App\Models;

use App\Http\Requests\UpdateUniversityRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\University
 *
 * @property int $id
 * @property string $name
 * @property string $website
 * @property int $country_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Agreement[] $agreement
 * @property-read int|null $agreement_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Campus[] $campuses
 * @property-read int|null $campuses_count
 * @property-read \App\Models\Country $country
 * @method static \Database\Factories\UniversityFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|University newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|University newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|University query()
 * @method static \Illuminate\Database\Eloquent\Builder|University whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|University whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|University whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|University whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|University whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|University whereWebsite($value)
 * @mixin \Eloquent
 */
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

    public function campuses(): \Illuminate\Database\Eloquent\Relations\HasMany
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
