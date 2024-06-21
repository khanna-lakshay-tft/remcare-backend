<?php

namespace App\Http\Controllers\Api;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class PatientController extends Controller
{

    /**
     * Display a listing of the patients.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            // Retrieve all patients
            $patients = Patient::all();
            return response()->json($patients);
        } catch (\Exception $e) {
            // Handle exception if retrieving patients fails
            return response()->json(['error' => 'Failed to retrieve patients' . $e->getMessage()], config('constants.INTERNAL_SERVICE_ERROR'));
        }
    }

    /**
     * Create a new patient.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // Validate incoming request data
            $request->validate([
                'first_name' => 'required|string|min:1|max:255',
                'last_name' => 'required|string|min:1|max:255',
                'email' => 'required|email|unique:patients,email',
                'dob' => 'required|date',
                'risk_category' => 'required|in:A,B,C,D',
                'appointment_time' => 'required|date'
            ]);

            // Create a new patient record
            $patient = Patient::create($request->all());

            // Return the newly created patient as JSON response
            return response()->json($patient, 201);
        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json(['error' => $e->validator->errors()], config('constants.VALIDATION_ERROR'));
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json(['error' => 'Failed to create patient' . $e->getMessage()], config('constants.INTERNAL_SERVICE_ERROR'));
        }
    }

    /**
     * Display the specified patient.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            // Find and retrieve a specific patient by ID
            $patient = Patient::findOrFail($id);
            return response()->json($patient);
        } catch (ModelNotFoundException $e) {
            // Handle case where patient with specified ID is not found
            return response()->json(['error' => 'Patient not found' . $e->getMessage()], config('constants.NOT_FOUND_ERROR'));
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json(['error' => 'Failed to fetch patient' . $e->getMessage()], config('constants.INTERNAL_SERVICE_ERROR'));
        }
    }

    /**
     * Update a patient.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            // Validate incoming request data
            $request->validate([
                'email' => 'email|unique:patients,email,' . $id,
            ]);

            // Find patient by ID
            $patient = Patient::find($id);

            if (!$patient) {
                // Handle case where patient with specified ID is not found
                return response()->json(['error' => 'Patient not found'], config('constants.NOT_FOUND_ERROR'));
            }

            // Update patient record
            $patient->update($request->all());

            // Return success message
            return response()->json(['message' => 'Patient updated successfully']);
        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json(['error' => $e->validator->errors()],config('constants.VALIDATION_ERROR'));
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json(['error' => 'Failed to update patient' . $e->getMessage()], config('constants.INTERNAL_SERVICE_ERROR'));
        }
    }

    /**
     * Remove a patient.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            // Find patient by ID
            $patient = Patient::find($id);

            if (!$patient) {
                // Handle case where patient with specified ID is not found
                return response()->json(['error' => 'Patient not found'], config('constants.NOT_FOUND_ERROR'));
            }

            // Delete patient record
            $patient->delete();

            // Return success message
            return response()->json(['message' => 'Patient deleted successfully']);
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json(['error' => 'Failed to delete patient' . $e->getMessage()], config('constants.INTERNAL_SERVICE_ERROR'));
        }
    }

    /**
     * Retrieve patient data for the charts.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData()
    {
        try {
            // Fetch patients with appointments within the last 4 weeks
            $patients = Patient::where('appointment_time', '>=', Carbon::now()->subWeeks(4))->get();

            // Helper function to calculate week number
            function getWeekNumber($date) {
                $startDate = Carbon::now()->subWeeks(4)->startOfWeek();
                return (int)ceil(($date->diffInDays($startDate) + $startDate->dayOfWeek + 1) / 7);
            }

            // Initialize data structure for chart
            $data = [
                'labels' => [],
                'datasets' => [
                    [
                        'label' => 'Risk Category A',
                        'data' => [],
                        'backgroundColor' => '#519DE9',
                    ],
                    [
                        'label' => 'Risk Category B',
                        'data' => [],
                        'backgroundColor' => '#7CC674',
                    ],
                    [
                        'label' => 'Risk Category C',
                        'data' => [],
                        'backgroundColor' => '#73C5C5',
                    ],
                    [
                        'label' => 'Risk Category D',
                        'data' => [],
                        'backgroundColor' => '#F6D173',
                    ],
                ],
            ];

            // Populate data for each patient
            foreach ($patients as $patient) {
                $appointmentDate = Carbon::parse($patient->appointment_time);
                $weekNumber = getWeekNumber($appointmentDate);
                $weekLabel = 'Week ' . $weekNumber;

                // Initialize data arrays for each risk category if week label doesn't exist
                if (!in_array($weekLabel, $data['labels'])) {
                    $data['labels'][] = $weekLabel;
                    foreach ($data['datasets'] as &$dataset) {
                        $dataset['data'][] = 0;
                    }
                }

                $weekIndex = array_search($weekLabel, $data['labels']);

                // Increment count for the corresponding risk category and week
                foreach ($data['datasets'] as &$dataset) {
                    if ($dataset['label'] === 'Risk Category ' . $patient->risk_category) {
                        $dataset['data'][$weekIndex]++;
                    }
                }
            }

            // Remove labels from data (to manage them on the frontend)
            unset($data['labels']);

            // Return chart data as JSON response
            return response()->json($data);
        } catch (\Exception $e) {
            // Handle all exceptions
            return response()->json(['error' => 'Failed to fetch data' . $e->getMessage()], config('constants.INTERNAL_SERVICE_ERROR'));
        }
    }
}
