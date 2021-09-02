<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "full_name", "email", "cpf", "rg", "birth_date", "address", "complement", "district", "zip_code", "number", "city", "state", 'deleted_at'
    ];


    public function salaries(): HasMany
    {
        return $this->hasMany(Salary::class);
    }

}
