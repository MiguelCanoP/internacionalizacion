<?php

namespace App\Models;

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
 */
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
