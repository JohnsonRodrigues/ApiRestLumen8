<?php

namespace App\Services\Employee;

use App\Models\Employee;
use App\Repositories\Employee\EmployeeRepository;

class EmployeeService
{
    private EmployeeRepository $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function findOrFail(string $id)
    {
        return $this->employeeRepository->findOrFail($id);
    }

    public function create(array $attributes)
    {
        return $this->employeeRepository->create($attributes);
    }

    public function update(string $id, array $attributes): Employee
    {
        return $this->employeeRepository->update($id, $attributes);
    }

    public function delete(string $id): ?bool
    {
        return $this->employeeRepository->delete($id);
    }

    public function all()
    {
        return $this->employeeRepository->all();
    }

    public function allWith()
    {
        return $this->employeeRepository->allWith();
    }

    public function whereOrWhere(array $where, array $orWhere)
    {
        return $this->employeeRepository->whereOrWhere([$where], [$orWhere]);
    }

    public function linkSalary(array $attributes)
    {
        $employee = $this->findOrFail($attributes['employee_id']);
        $employee->salary = $attributes['salary'];
        $employee->update();
        return $employee;
    }
}
