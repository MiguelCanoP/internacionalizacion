<?php

namespace App\Models;

use App\Http\Requests\UpdateAgreementRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Agreement
 *
 * @property int $id
 * @property string $name
 * @property string $city
 * @property int $agreement_type_id
 * @property string $status
 * @property string $information
 * @property string $contact_info
 * @property int $program_id
 * @property int $university_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\University $University
 * @property-read \App\Models\AgreementType $agreementType
 * @property-read \App\Models\Program $program
 * @method static \Database\Factories\AgreementFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Agreement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Agreement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Agreement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Agreement whereAgreementTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agreement whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agreement whereContactInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agreement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agreement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agreement whereInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agreement whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agreement whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agreement whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agreement whereUniversityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agreement whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\University $university
 */
class Agreement extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function patch($id, UpdateAgreementRequest $request): void
    {
        $data = [
            'agreement_type_id' => $request->input('agreement_type')['id'],
            'status' => $request->input('status'),
            'information' => $request->input('information'),
            'contact_info' => $request->input('contact_info'),
            'university_id' => $request->input('university'),
        ];
        if ($id === 0) {
            $agreement = self::create($data);
        } else {
            $agreement = self::updateOrCreate(['id' => $id], $data);
        }
        $programIds = array_column($request->input('programs'), 'id');
        $agreement->programs()->sync($programIds);
    }

    public function programs(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Program::class)->with('faculty');
    }

    public function university(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(University::class)->with('country')
        ->orderBy('name', 'ASC');
    }

    public function agreementType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AgreementType::class);
    }

}
