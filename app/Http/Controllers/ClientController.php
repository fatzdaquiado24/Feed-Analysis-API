<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Cloudinary\Uploader;
use App\Client;
use App\Notifications\AccountApproved;
use App\Notifications\AccountDenied;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Client::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::find($id);
        if($client) {
            return $client;
        } else {
            return response()->json(['message' => 'Client not found'], 404);
        }
    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function update(Request $request, $id)
    {
        $client = Client::find($id);

        if($client) {
            $request->validate([
                'status' => 'required|in:Approved,Denied',
            ]);

            $client->status = $request->status;

            if($client->save()) {
                if($client->status == 'Approved') {
                    $client->notify(new AccountApproved());
                    return response()->json(['message' => 'Client approved successfully'], 200);
                }
                $client->notify(new AccountDenied());
                return response()->json(['message' => 'Client denied successfully'], 200);
            }
            return response()->json(['message' => 'An error has occurred'], 500);
        } else {
            return response()->json(['message' => 'Client not found'], 404);
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
        $client = Client::find($id);
        if($client) {
            $validIdImageId = explode(".", basename($client->valid_id))[0];
            if($client->business_permit != null) {
                $businessPermitImageId = explode(".", basename($client->business_permit))[0];
            }

            if($client->status != 'Approved' ? $client->forceDelete() : $client->delete()) {
                Uploader::destroy($validIdImageId);
                if($rlaNumberRequest->business_permit != null) Uploader::destroy($businessPermitImageId);
                return response()->json(['message' => 'Client deleted successfully'], 200);
            }
            return response()->json(['message' => 'An error has occurred'], 500);
        } else {
            return response()->json(['message' => 'Client not found'], 404);
        }
    }
}
