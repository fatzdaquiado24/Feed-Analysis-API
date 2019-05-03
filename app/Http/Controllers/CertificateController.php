<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\LaboratoryAnalysisRequest;
use App\Http\Resources\LaboratoryAnalysisRequest as LaboratoryAnalysisRequestResource;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;

class CertificateController extends Controller
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
        $laboratoryAnalysisRequest = new LaboratoryAnalysisRequestResource(LaboratoryAnalysisRequest::find($id));
        if($laboratoryAnalysisRequest) {
            $pdf = new Dompdf();
            $pdf->loadHtml(View::make('certificate', ['data' => $laboratoryAnalysisRequest]));
            $pdf->render();
            return response()->json(['pdf' => base64_encode($pdf->output())]);
        } else {
            return response()->json(['message' => 'Transaction not found'], 404);
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
        //
    }
}
