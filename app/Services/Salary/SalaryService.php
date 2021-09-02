<?php

namespace App\Services\Salary;

use App\Models\Salary;
use App\Repositories\Salary\SalaryRepository;

class SalaryService
{
    private SalaryRepository $salaryRepository;

    public function __construct(SalaryRepository $salaryRepository)
    {
        $this->salaryRepository = $salaryRepository;
    }

    public function findOrFail(string $id)
    {
        return $this->salaryRepository->findOrFail($id);
    }

    public function create(array $attributes)
    {
        return $this->salaryRepository->create($attributes);
    }

    public function update(string $id, array $attributes): Salary
    {
        return $this->salaryRepository->update($id, $attributes);
    }

    public function delete(string $id): ?bool
    {
        return $this->salaryRepository->delete($id);
    }

    public function all()
    {
        return $this->salaryRepository->all();
    }

    public function whereOrWhere(array $where, array $orWhere)
    {
        return $this->salaryRepository->whereOrWhere([$where], [$orWhere]);
    }

    public function linkSalary(array $attributes)
    {
        $employee = $this->findOrFail($attributes['employee_id']);
        $employee->salary = $attributes['salary'];
        $employee->update();
        return $employee;
    }
}
