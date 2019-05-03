<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\CertificateReleaser;
use Hash;

class CertificateReleaserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CertificateReleaser::all();
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
            'email' => 'required|string|email|unique:certificate_releasers',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $certificateReleaser = new CertificateReleaser();
        $certificateReleaser->name = $request->name;
        $certificateReleaser->email = $request->email;
        $certificateReleaser->cellphone_number = $request->cellphone_number;
        $certificateReleaser->password = Hash::make($request->password);

        if($certificateReleaser->save()) {
            return response()->json(['message' => 'Certificate releaser created successfully'], 200);
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
        $certificateReleaser = CertificateReleaser::find($id);
        if($certificateReleaser) {
            return $certificateReleaser;
        } else {
            return response()->json(['message' => 'Certificate releaser not found'], 404);
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
        $certificateReleaser = CertificateReleaser::find($id);

        if($certificateReleaser) {
            $request->validate([
                'name' => 'sometimes|required|string',
                'cellphone_number' => 'nullable|digits:12|starts_with:63',
                'email' => 'sometimes|required|string|email|unique:certificate_releasers,email,'.$certificateReleaser->id,
                'password' => 'sometimes|required|string|min:8|confirmed',
            ]);

            $inputs = $request->only(['name', 'email', 'password']);
            foreach($inputs as $key => $value) {
                if($key == 'password') {
                    $certificateReleaser->password = Hash::make($value);
                } else {
                    $certificateReleaser->$key = $value;
                }
            }
            $certificateReleaser->cellphone_number = $request->cellphone_number;

            if($certificateReleaser->save()) {
                return response()->json(['message' => 'Certificate releaser updated successfully'], 200);
            }
            return response()->json(['message' => 'An error has occurred'], 500);
        } else {
            return response()->json(['message' => 'Certificate releaser not found'], 404);
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
        $certificateReleaser = CertificateReleaser::find($id);
        if($certificateReleaser) {
            if($certificateReleaser->delete()) {
                return response()->json(['message' => 'Certificate releaser deleted successfully'], 200);
            }
            return response()->json(['message' => 'An error has occurred'], 500);
        } else {
            return response()->json(['message' => 'Certificate releaser not found'], 404);
        }
    }
}
