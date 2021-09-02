<?php

namespace App\Repositories\Salary;

use App\Models\Salary;

class SalaryRepository
{
    private Salary $entity;

    public function __construct()
    {
        $this->entity = app(Salary::class);
    }

    public function findOrFail(string $id)
    {
        return $this->entity->newQuery()->findOrFail($id);
    }

    public function create(array $attributes)
    {
        return $this->entity->newQuery()->create($attributes);
    }

    public function all()
    {
        return $this->entity->newQuery()->get();
    }

    public function update(string $id, array $attributes): Salary
    {
        $salary = $this->findOrFail($id);
        if (!empty($attributes)) {
            $salary->update($attributes);
        }
        return $salary;
    }

    public function delete(string $id): ?bool
    {
        $salary = $this->findOrFail($id);
        return $salary->delete();
    }

    public function whereOrWhere(array $where, array $orWhere)
    {
        return $this->entity->newQuery()->where([[$where]])->orWhere([[$orWhere]])->get();
    }
}
