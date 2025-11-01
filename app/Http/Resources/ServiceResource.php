<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
   public function toArray(Request $request): array
{
    return [
                "id" => $this->id,
                "code" => $this->code,
                "title" => $this->title,
                "category" => $this->categories->title,
                "price" => $this->price,
                "type" => $this->type,
                "created_by" => $this->user ? $this->user->name : null, // Handle null user
                "updated_by" => $this->updatedUser ? $this->updatedUser->name : null, // Handle null updatedUser
                "status" => $this->status == 1 ? 'Active' : 'Inactive',
                "created_at" => $this->created_at,
                "updated_at" => $this->updated_at,
    ];
}
}
