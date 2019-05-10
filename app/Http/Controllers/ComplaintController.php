<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Complaint;
use App\Http\Resources\Complaint as ComplaintResource;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ComplaintResource::collection(Complaint::all());
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
            'description' => 'required|string',
        ]);

        $complaint = new Complaint();
        $complaint->description = $request->description;
        $complaint->client_id = auth()->user()->id;

        if($complaint->save()) {
            return response()->json(['message' => 'Complaint created successfully'], 200);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $complaint = Complaint::find($id);
        if($complaint) {
            if($complaint->delete()) {
                return response()->json(['message' => 'Complaint deleted successfully'], 200);
            }
            return response()->json(['message' => 'An error has occurred'], 500);
        } else {
            return response()->json(['message' => 'Complaint not found'], 404);
        }
    }
}
