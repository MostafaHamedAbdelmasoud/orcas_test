<?php

namespace App\Domain\User\Http\Resources\User;

use Illuminate\Http\Request;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function data(Request $request):array
    {
        return [
            'id'               => $this->id,
            'email'             => $this->email,
            'firstName'             => $this->firstName,
            'lastName'             => $this->lastName,
            'avatar'             => $this->avatar,
        ];
    }
}
