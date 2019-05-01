<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ChemicalTest;

class ChemicalTestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ChemicalTest::all();
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
            'parameter' => 'required|string',
            'method' => 'required|string',
            'fee' => 'required|numeric|min:0|max:999999.99',
        ]);

        $chemicalTest = new ChemicalTest();
        $chemicalTest->parameter = $request->parameter;
        $chemicalTest->method = $request->method;
        $chemicalTest->fee = $request->fee;

        if($chemicalTest->save()) {
            return response()->json(['message' => 'Chemical test created successfully'], 200);
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
        $chemicalTest = ChemicalTest::find($id);
        if($chemicalTest) {
            return ChemicalTest::find($id);
        } else {
            return response()->json(['message' => 'Chemical test not found'], 404);
        }
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
        $chemicalTest = ChemicalTest::find($id);

        if($chemicalTest) {
            $request->validate([
                'parameter' => 'sometimes|required|string',
                'method' => 'sometimes|required|string',
                'fee' => 'sometimes|required|numeric|min:0|max:999999.99',
            ]);

            $inputs = $request->only(['parameter', 'method', 'fee']);
            foreach($inputs as $key => $value) {
                $chemicalTest->$key = $value;
            }

            if($chemicalTest->save()) {
                return response()->json(['message' => 'Chemical test updated successfully'], 200);
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
        $chemicalTest = ChemicalTest::find($id);
        if($chemicalTest) {
            if($chemicalTest->delete()) {
                return response()->json(['message' => 'Chemical test deleted successfully'], 200);
            }
            return response()->json(['message' => 'An error has occurred'], 500);
        } else {
            return response()->json(['message' => 'Chemical test not found'], 404);
        }
    }
}
