<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Chemist;
use Hash;

class ChemistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Chemist::all();
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
            'name' => 'required|string',
            'cellphone_number' => 'nullable|digits:12|starts_with:63',
            'email' => 'required|string|email|unique:chemists',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $chemist = new Chemist();
        $chemist->name = $request->name;
        $chemist->email = $request->email;
        $chemist->cellphone_number = $request->cellphone_number;
        $chemist->password = Hash::make($request->password);

        if($chemist->save()) {
            return response()->json(['message' => 'Chemist created successfully'], 200);
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
        $chemist = Chemist::find($id);
        if($chemist) {
            return $chemist;
        } else {
            return response()->json(['message' => 'Chemist not found'], 404);
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
        $chemist = Chemist::find($id);

        if($chemist) {
            $request->validate([
                'name' => 'sometimes|required|string',
                'cellphone_number' => 'nullable|digits:12|starts_with:63',
                'email' => 'sometimes|required|string|email|unique:chemists,email,'.$chemist->id,
                'password' => 'sometimes|required|string|min:8|confirmed',
            ]);

            $inputs = $request->only(['name', 'email', 'password']);
            foreach($inputs as $key => $value) {
                if($key == 'password') {
                    $chemist->password = Hash::make($value);
                } else {
                    $chemist->$key = $value;
                }
            }
            $chemist->cellphone_number = $request->cellphone_number;

            if($chemist->save()) {
                return response()->json(['message' => 'Chemist updated successfully'], 200);
            }
            return response()->json(['message' => 'An error has occurred'], 500);
        } else {
            return response()->json(['message' => 'Chemist not found'], 404);
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
        $chemist = Chemist::find($id);
        if($chemist) {
            if($chemist->delete()) {
                return response()->json(['message' => 'Chemist deleted successfully'], 200);
            }
            return response()->json(['message' => 'An error has occurred'], 500);
        } else {
            return response()->json(['message' => 'Chemist not found'], 404);
        }
    }
}
