<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsumerLoginIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->business_info?->name,
            'api_key' => $this->api_keys?->where('name', 'keeless_auth')->first()->name,
            'email_needed' => $this->business_info?->use_email_for_login,
            'username_needed' => $this->business_info?->use_username_for_login,
            'phone_needed' => $this->business_info?->use_phone_for_login,
        ];
    }
}
