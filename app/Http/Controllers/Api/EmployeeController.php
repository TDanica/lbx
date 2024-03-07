<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEmployeeRequest;
use App\Services\CsvService;
use App\Services\EmployeeService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    protected $csvService;
    protected $employeeService;

    public function __construct(CsvService $csvService, EmployeeService $employeeService)
    {
        $this->csvService = $csvService;
        $this->employeeService = $employeeService;
    }

    public function index()
    {
        $employees = $this->employeeService->getEmployees();

        return response()->json(['success' => true, 'data' => $employees]);
    }

    public function store(CreateEmployeeRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $filePath = $validatedData['file'];

            $this->csvService->processCsv($filePath);

            return response()->json(['success' => true, 'message' => 'Employees imported successfully'], 201);
        } catch (\Exception $ex) {
            Log::error('Error importing employees', ['message' => $ex->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to import employees'], 500);
        }
    }

    public function show($id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
            $employee = $this->employeeService->getEmployeeById($decryptedId);
            return response()->json(['success' => true, 'data' => $employee]);
        } catch (\Exception $ex) {
            Log::error('Error retrieving employee', ['message' => $ex->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Employee not found'], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $this->employeeService->deleteEmployeeById($id);
            return response()->json(['success' => true, 'message' => 'Employee deleted successfully']);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['success' => false, 'message' => 'Employee not found'], 404);
        } catch (\Exception $ex) {
            Log::error('Error deleting employee', ['message' => $ex->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to delete employee'], 500);
        }
    }
}
