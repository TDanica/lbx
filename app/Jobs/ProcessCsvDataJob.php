<?php

namespace App\Jobs;

use App\Models\Api\Employee;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessCsvDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $columnNames;
    /**
     * Create a new job instance.
     */
    public function __construct(array $data, array $columnNames)
    {
        $this->data = $data;
        $this->columnNames = $columnNames;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::beginTransaction();

        try {
            foreach ($this->data as $employee) {
                $this->processEmployee($employee);
            }
            DB::commit();
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            Log::error('Error importing employees: ' . $e->getMessage());
        }
    }

    protected function processEmployee(array $employeeData)
    {
        // Map column names to data
        $rowData = array_combine($this->columnNames, $employeeData);

        // Prepare data for insertion
        $employeeAttributes = [
            'employee_id' => $rowData['Emp ID'],
            'user_name' => $rowData['User Name'],
            'name_prefix' => $rowData['Name Prefix'],
            'first_name' => $rowData['First Name'],
            'middle_initial' => $rowData['Middle Initial'],
            'last_name' => $rowData['Last Name'],
            'gender' => $rowData['Gender'],
            'email' => $rowData['E Mail'],
            'date_of_birth' => $this->parseDate($rowData['Date of Birth']),
            'time_of_birth' => $rowData['Time of Birth'],
            'age_in_years' => (float) $rowData['Age in Yrs.'],
            'date_of_joining' => $this->parseDate($rowData['Date of Joining']),
            'age_in_company' => (float) $rowData['Age in Company (Years)'],
            'phone_number' => $rowData['Phone No. '],
            'place_name' => $rowData['Place Name'],
            'county' => $rowData['County'],
            'city' => $rowData['City'],
            'zip' => $rowData['Zip'],
            'region' => $rowData['Region'],
        ];

        // Create or update the employee
        try {
            Employee::updateOrCreate(['employee_id' => $employeeAttributes['employee_id']], $employeeAttributes);
        } catch (\Exception $e) {
            // Handle database errors
            dd($e->getMessage());
            Log::error('Error processing employee data: ' . $e->getMessage());
            throw new \Exception('Failed to process employee data');
        }
    }

    protected function parseDate(string $dateString): ?string
    {
        if (!empty($dateString)) {
            // Remove any non-date-related characters from the end of the string
            $cleanDateString = preg_replace('/[^0-9\/]/', '', $dateString);
            if (!empty($cleanDateString)) {
                return Carbon::createFromFormat('m/d/Y', $cleanDateString)->format('Y-m-d');
            }
        }
        return null;
    }
}
