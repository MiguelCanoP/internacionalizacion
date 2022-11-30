<?php

namespace App\Models;

use App\Http\Requests\UpdateCampusRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Campus
 *
 * @property int $id
 * @property string $name
 * @property string $city
 * @property int $university_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\University|null $agreements
 * @method static \Database\Factories\CampusFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Campus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Campus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Campus query()
 * @method static \Illuminate\Database\Eloquent\Builder|Campus whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campus whereUniversityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Campus extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function agreements(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(University::class);

    }

    public static function patch($id, UpdateCampusRequest $request)
    {
        $data = [
            'name' => $request->input('name'),
            'city' => $request->input('city'),
            'university_id' => $request->input('university_id'),
        ];
        if ($id === 0) {
            return self::create($data);
        }

        return self::updateOrCreate(['id' => $id], $data);
    }
}
