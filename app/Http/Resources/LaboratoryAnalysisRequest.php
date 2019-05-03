<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\FeedAnalysisTest as FeedAnalysisTestResource;

class LaboratoryAnalysisRequest extends JsonResource
{
    /**
     *
     * Transform the resource into an array.
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $resource = parent::toArray($request);
        $resource["client"] = [
            'name' => $this->client->name,
            'email' => $this->client->email,
            'cellphone_number' => $this->client->cellphone_number
        ];
        $resource["receiver"] = $this->receiver != null ? [
            'name' => $this->receiver->name,
            'email' => $this->receiver->email
        ] : '-';
        $resource["feed_analysis_tests"] = FeedAnalysisTestResource::collection($this->feed_analysis_tests);
        return $resource;
    }
}
