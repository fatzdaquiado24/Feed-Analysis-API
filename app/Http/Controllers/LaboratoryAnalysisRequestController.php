<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AppointmentDate;
use App\LaboratoryAnalysisRequest;
use App\Http\Resources\LaboratoryAnalysisRequest as LaboratoryAnalysisRequestResource;
use App\ChemicalTest;
use App\Receiver;
use App\Chemist;
use DB;

class LaboratoryAnalysisRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user() instanceof Receiver) {
            return LaboratoryAnalysisRequestResource::collection(LaboratoryAnalysisRequest::where('receiver_id', null)
                ->where('appointment_date', date('Y-m-d'))->get());
        } else if(auth()->user() instanceof Chemist) {
            return LaboratoryAnalysisRequestResource::collection(LaboratoryAnalysisRequest::whereNotNull('receiver_id')->get());
        }
        return LaboratoryAnalysisRequestResource::collection(LaboratoryAnalysisRequest::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'appointment_date' => [
                'required',
                'date',
                'after_or_equal:today',
                function ($attribute, $value, $fail) use ($request) {
                    $appointmentDate = AppointmentDate::where('date', $value)->first();
                    if(!$appointmentDate) {
                        $fail('There is no available schedule on the selected appointment date');
                    } else if($appointmentDate->appointed >= $appointmentDate->maximum_appointment) {
                        $fail('The selected appointment date is fully scheduled');
                    }
                }
            ],
            'feed_analysis_tests' => 'required|array|min:1',
            'feed_analysis_tests.*.sample_name' => 'required|string',
            'feed_analysis_tests.*.analysis_requests' => 'required|array|min:1',
            'feed_analysis_tests.*.analysis_requests.*' => 'exists:chemical_tests,id',
        ]);

        DB::beginTransaction();
        try {
            $laboratoryAnalysisRequest = LaboratoryAnalysisRequest::create([
                'appointment_date' => $request->appointment_date,
                'client_id' => $request->user()->id,
            ]);

            $feedAnalysisTests = $laboratoryAnalysisRequest->feed_analysis_tests()->createMany($request->feed_analysis_tests);
            foreach($feedAnalysisTests as $index => $feedAnalysisTest) {
                $chemicalTestIds = $request->feed_analysis_tests[$index]["analysis_requests"];
                $analysis_requests = array();

                foreach($chemicalTestIds as $id) {
                    $chemicalTest = ChemicalTest::find($id);
                    array_push($analysis_requests, [
                        'parameter' => $chemicalTest->parameter,
                        'method' => $chemicalTest->method,
                        'fee' => $chemicalTest->fee
                    ]);
                }
                $feedAnalysisTest->analysis_requests()->createMany($analysis_requests);
            }
            DB::commit();

            return response()->json(['message' => 'Laboratory analysis request created successfully'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $laboratoryAnalysisRequest = LaboratoryAnalysisRequest::find($id);

        if($laboratoryAnalysisRequest) {
            // if($request->user() instanceof Receiver) {
                if($laboratoryAnalysisRequest->receiver_id != null) {
                    return response()->json(['message' => 'Sample(s) already received'], 422);
                } else if($laboratoryAnalysisRequest->appointment_date != date('Y-m-d')) {
                    return response()->json(['message' => 'Can only accept sample(s) on requests with today\'s appointed date'], 422);
                }
                $laboratoryAnalysisRequest->receiver_id = $request->user()->id;
                
                if($laboratoryAnalysisRequest->save()) {
                    return response()->json(['message' => 'Request updated successfully'], 200);
                }
            // }
            return response()->json(['message' => 'An error has occurred'], 500);
        } else {
            return response()->json(['message' => 'Request not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
