<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Complaint extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
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
        return $resource;
    }
}
