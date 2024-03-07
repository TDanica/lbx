<?php

namespace App\Models\Api;

use App\Casts\TimeCast;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'user_name',
        'name_prefix',
        'first_name',
        'middle_initial',
        'last_name',
        'gender',
        'email',
        'date_of_birth',
        'time_of_birth',
        'age_in_years',
        'date_of_joining',
        'age_in_company',
        'phone_number',
        'place_name',
        'county',
        'city',
        'zip',
        'region',
        'time_of_birth'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'date_of_joining' => 'date',
    ];

    protected function id(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) =>  Crypt::encrypt($value)
        );
    }

    protected function dateOfBirth(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) =>  Carbon::parse($value)->format('n/j/Y')
        );
    }

    protected function dateOfJoining(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) =>  Carbon::parse($value)->format('n/j/Y')
        );
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->format('n/j/Y')
        );
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) =>  Carbon::parse($value)->format('n/j/Y')
        );
    }
}
