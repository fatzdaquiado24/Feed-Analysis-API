<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Client;
use App\CustomerFeedback;
use App\Http\Resources\CustomerFeedback as CustomerFeedbackResource;

class CustomerFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user() instanceof Client) {
            $feedback = CustomerFeedback::where('client_id', auth()->user()->id)->first();
            if($feedback) {
                return $feedback;
            } else {
                return response()->json(null);
            }
        }
        return CustomerFeedbackResource::collection(CustomerFeedback::all());
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
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $feedback = new CustomerFeedback();
        $feedback->rating = $request->rating;
        $feedback->comment = $request->comment;
        $feedback->client_id = auth()->user()->id;

        if($feedback->save()) {
            return response()->json(['message' => 'Feedback created successfully'], 200);
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
        $feedback = CustomerFeedback::find($id);

        if($feedback) {
            $request->validate([
                'rating' => 'sometimes|required|integer|min:1|max:5',
                'comment' => 'nullable|string',
            ]);

            $feedback->rating = $request->rating;
            $feedback->comment = $request->comment;

            if($feedback->save()) {
                return response()->json(['message' => 'Feedback updated successfully'], 200);
            }
            return response()->json(['message' => 'An error has occurred'], 500);
        } else {
            return response()->json(['message' => 'Feedback not found'], 404);
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
