<?php

namespace App\Http\Controllers\Employee;

use App\Contracts\Core\Services\ApiResponseService;
use App\Http\Controllers\Controller;
use App\Services\Employee\EmployeeService;
use App\Services\Salary\SalaryService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    private EmployeeService $employeeService;
    private SalaryService $salaryService;
    private ApiResponseService $apiResponseService;

    public function __construct(EmployeeService $employeeService, SalaryService $salaryService, ApiResponseService $apiResponseService)
    {
        $this->employeeService = $employeeService;
        $this->salaryService = $salaryService;
        $this->apiResponseService = $apiResponseService;
    }

    public function index(): JsonResponse
    {
        try {
            return $this->apiResponseService->success($this->employeeService->allWith());
        } catch (Exception $e) {
            return $this->apiResponseService->error($e->getMessage());
        }
    }

    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'unique:employees,email'],
            'cpf' => ['required', 'string', 'unique:employees,cpf'],
            'rg' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'complement' => ['sometimes', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'zip_code' => ['required', 'string', 'max:255'],
            'number' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
        ]);

        try {
            DB::beginTransaction();
            $employee = $this->employeeService->create($request->all());
            DB::commit();
            return $this->apiResponseService->success($employee);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->apiResponseService->error($e->getMessage());
        }
    }

    public function show(string $id): JsonResponse
    {
        try {
            $employee = $this->employeeService->findOrFail($id);
            return $this->apiResponseService->success($employee);
        } catch (Exception $e) {
            return $this->apiResponseService->error($e->getMessage());
        }
    }

    public function search(string $search): JsonResponse
    {
        try {
            $employee = $this->employeeService->whereOrWhere([['id' => $search]], [['cpf' => $search]]);
            return $this->apiResponseService->success($employee);
        } catch (Exception $e) {
            return $this->apiResponseService->error($e->getMessage());
        }
    }

    public function update(Request $request, string $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $this->validate($request, [
                'full_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', Rule::unique('employees', 'email')->ignore($id)],
                'cpf' => ['required', 'string', Rule::unique('employees', 'cpf')->ignore($id)],
                'rg' => ['required', 'string', 'max:255'],
                'birth_date' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string', 'max:255'],
                'complement' => ['sometimes', 'string', 'max:255'],
                'district' => ['required', 'string', 'max:255'],
                'zip_code' => ['required', 'string', 'max:255'],
                'number' => ['required', 'string', 'max:255'],
                'city' => ['required', 'string', 'max:255'],
                'state' => ['required', 'string', 'max:255'],
            ]);

            $employee = $this->employeeService->update($id, $request->all());
            DB::commit();
            return $this->apiResponseService->success($employee);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->apiResponseService->error($e->getMessage());
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $employee = $this->employeeService->delete($id);
            DB::commit();
            return $this->apiResponseService->success($employee);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->apiResponseService->error($e->getMessage());
        }
    }

    public function linkSalary(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->validate($request, [
                'employee_id' => ['required', 'string', 'exists:employees,id'],
                'salary' => ['required', 'numeric']
            ]);
            $salary = $this->salaryService->create($request->all());
            DB::commit();
            return $this->apiResponseService->success($salary);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->apiResponseService->error($e->getMessage());
        }
    }

}


