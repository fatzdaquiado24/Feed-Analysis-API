<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Receiver;
use Hash;

class ReceiverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Receiver::all();
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
            'email' => 'required|string|email|unique:receivers',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $receiver = new Receiver();
        $receiver->name = $request->name;
        $receiver->email = $request->email;
        $receiver->cellphone_number = $request->cellphone_number;
        $receiver->password = Hash::make($request->password);

        if($receiver->save()) {
            return response()->json(['message' => 'Receiver created successfully'], 200);
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
        $receiver = Receiver::find($id);
        if($receiver) {
            return $receiver;
        } else {
            return response()->json(['message' => 'Receiver not found'], 404);
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
        $receiver = Receiver::find($id);

        if($receiver) {
            $request->validate([
                'name' => 'sometimes|required|string',
                'cellphone_number' => 'nullable|digits:12|starts_with:63',
                'email' => 'sometimes|required|string|email|unique:receivers,email,'.$receiver->id,
                'password' => 'sometimes|required|string|min:8|confirmed',
            ]);

            $inputs = $request->only(['name', 'email', 'password']);
            foreach($inputs as $key => $value) {
                if($key == 'password') {
                    $receiver->password = Hash::make($value);
                } else {
                    $receiver->$key = $value;
                }
            }
            $receiver->cellphone_number = $request->cellphone_number;

            if($receiver->save()) {
                return response()->json(['message' => 'Receiver updated successfully'], 200);
            }
            return response()->json(['message' => 'An error has occurred'], 500);
        } else {
            return response()->json(['message' => 'Receiver not found'], 404);
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
        $receiver = Receiver::find($id);
        if($receiver) {
            if($receiver->delete()) {
                return response()->json(['message' => 'Receiver deleted successfully'], 200);
            }
            return response()->json(['message' => 'An error has occurred'], 500);
        } else {
            return response()->json(['message' => 'Receiver not found'], 404);
        }
    }
}
