<?php

namespace App\Repositories\Employee;

use App\Models\Employee;

class EmployeeRepository
{
    private Employee $entity;

    public function __construct()
    {
        $this->entity = app(Employee::class);
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

    public function allWith()
    {
        return $this->entity->newQuery()->with('salaries')->get();
    }

    public function update(string $id, array $attributes): Employee
    {
        $employee = $this->findOrFail($id);
        if (!empty($attributes)) {
            $employee->update($attributes);
        }
        return $employee;
    }

    public function delete(string $id): ?bool
    {
        $employee = $this->findOrFail($id);
        return $employee->delete();
    }

    public function whereOrWhere(array $where, array $orWhere)
    {
        return $this->entity->newQuery()->where([[$where]])->orWhere([[$orWhere]])->get();
    }
}
