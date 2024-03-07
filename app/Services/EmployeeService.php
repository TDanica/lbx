<?php

namespace App\Services;

use App\Models\Api\Employee;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EmployeeService
{
    public function getEmployees(int $perPage = 10)
    {
        $cacheKey = 'employees_' . md5($perPage . '_' . now()->timestamp);

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($perPage) {
            return Employee::paginate($perPage);
        });
    }

    public function getEmployeeById($id)
    {
        return Employee::findOrFail($id);
    }

    public function deleteEmployeeById($id)
    {
        $employee = Employee::find($id);
        if (!$employee)
            throw new ModelNotFoundException('Employee not found');

        $employee->delete();
    }
}
