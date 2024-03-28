<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        // On retourne uniquement "name" et "email"
        return [
            "name" => ucfirst($this->name), // La 1er lettre en majuscule
            "email" => $this->email
        ];
    }
}
