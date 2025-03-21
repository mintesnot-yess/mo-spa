<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->created_at->format('Y-m-d'),
            'staf_name' => $this->employee->name,
            'customer_name' => $this->client->name,
            'customer_type' => $this->client->type,
            'service' => $this->service->title,
            'status' => $this->status == 0 ? 'Active' : 'Inactive',
            'is_new' => $this->status == 1 ? 'yes' : 'no',
        ];
    }
}
