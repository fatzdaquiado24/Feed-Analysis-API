<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AnalysisRequest;

class AnalysisRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $analysisRequest = AnalysisRequest::find($id);

        if($analysisRequest) {
            $request->validate([
                'result' => 'required|numeric|min:0|max:100',
            ]);

            $analysisRequest->result = $request->result;
            $analysisRequest->chemist_id = $request->user()->id;

            if($analysisRequest->save()) {
                return response()->json(['message' => 'Result updated successfully'], 200);
            }
            return response()->json(['message' => 'An error has occurred'], 500);
        } else {
            return response()->json(['message' => 'Chemical test not found'], 404);
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
