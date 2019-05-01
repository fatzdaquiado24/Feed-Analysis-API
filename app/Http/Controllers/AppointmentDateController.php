<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AppointmentDate;
use App\LaboratoryAnalysisRequest;

class AppointmentDateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AppointmentDate::all();
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
            'date' => 'required|date|after_or_equal:today|unique:appointment_dates',
            'maximum_appointment' => 'required|integer|min:1|max:999',
        ]);

        $appointmentDate = new AppointmentDate();
        $appointmentDate->date = $request->date;
        $appointmentDate->maximum_appointment = $request->maximum_appointment;

        if($appointmentDate->save()) {
            return response()->json(['message' => 'Appointment date created successfully'], 200);
        }
        return response()->json(['message' => 'An error has occurred'], 500);
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
        $appointmentDate = AppointmentDate::find($id);

        if($appointmentDate) {
            $request->request->add(['date' => $appointmentDate->date]);
            $request->validate([
                'date' => 'after_or_equal:today',
                'maximum_appointment' => 'required|integer|min:1|max:999',
            ]);
            
            if($request->maximum_appointment < $appointmentDate->maximum_appointment) {
                if($request->maximum_appointment < $appointmentDate->appointed) {
                    return response()->json(['message' => 'There are more appointed clients than the number you\'ve entered'], 500);
                }
            }
            $appointmentDate->maximum_appointment = $request->maximum_appointment;

            if($appointmentDate->save()) {
                return response()->json(['message' => 'Appointment date updated successfully'], 200);
            }
            return response()->json(['message' => 'An error has occurred'], 500);
        } else {
            return response()->json(['message' => 'Appointment date not found'], 404);
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
