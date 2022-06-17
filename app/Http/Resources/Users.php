<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Users extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'usuid' => $this->usuid,
            'usunombre' => $this->usunombre,
            'correo' => $this->correo,
            'usupass' => $this->usupass,        
        ];
    }
}
