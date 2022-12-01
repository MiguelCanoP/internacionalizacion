<?php

namespace App\Models;

use App\Http\Requests\UpdateAgreementTypeRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AgreementType
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Agreement[] $agreement
 * @property-read int|null $agreement_count
 * @method static \Database\Factories\AgreementTypeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|AgreementType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AgreementType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AgreementType query()
 * @method static \Illuminate\Database\Eloquent\Builder|AgreementType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AgreementType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AgreementType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AgreementType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AgreementType extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function agreement(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Agreement::class);
    }

    public static function patch($id, UpdateAgreementTypeRequest $request)
    {
        $data = [
            'name' => $request->input('name'),
        ];
        if ($id === 0) {
            return self::create($data);
        }

        return self::updateOrCreate(['id' => $id], $data);
    }
}
