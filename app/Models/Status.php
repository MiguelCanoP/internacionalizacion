<?php

namespace App\Models;

use App\Http\Requests\UpdateAgreementRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Status extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function getAvaliable(): array
    {
        return [
            [
                'id' => 'vigente',
                'name' => 'vigente'],
            [
                'id' => 'en renovación',
                'name' => 'en renovación'],
            [
                'id' => 'vencido',
                'name' => 'vencido']
        ];
    }

}
