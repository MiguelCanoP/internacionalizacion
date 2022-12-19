<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Program
 *
 * @property int $id
 * @property string $name
 * @property int $faculty_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Agreement[] $agreement
 * @property-read int|null $agreement_count
 * @property-read \App\Models\Faculty $faculty
 * @method static \Database\Factories\ProgramFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Program newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Program newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Program query()
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereFacultyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Program extends Model
{
    use HasFactory;
    public function faculty(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }
    public function agreement(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Agreement::class);
    }
}
