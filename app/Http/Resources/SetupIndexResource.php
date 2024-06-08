<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SetupIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $fields = ["Email"];
        if($this->businessInfo?->use_phone) {
            $fields[] = "Phone";
        }
        if($this->businessInfo?->use_username) {
            $fields[] = "Username";
        }
        $loginFields = ["Email"];
        if($this->businessInfo?->use_phone_for_login) {
            $loginFields[] = "Phone";
        }
        if($this->businessInfo?->use_username_for_login) {
            $loginFields[] = "Username";
        }
        return [
            'business_info' => [
                'id' => $this->businessInfo?->id,
                'name' => $this->businessInfo?->name,
                'domain' => $this->businessInfo?->domain,
                'privacy_policy' => $this->businessInfo?->privacy_policy,
                'terms_of_use' => $this->businessInfo?->terms_of_use,
                'use_api' => $this->businessInfo?->use_api ?? false,
                'use_name' => $this->businessInfo?->use_username ?? false,
                'fields' => $fields,
                'login_fields' => $loginFields,
                'web_url' => $this->businessInfo?->web_url,
                'support_email' => $this->businessInfo?->support_email,
            ],
            'email_info' => [
                'use_smtp' => $this->emailInfo?->use_smtp,
                'use_otp' => $this->emailInfo?->use_otp,
                'email' => $this->emailInfo?->email,
                'server' => $this->emailInfo?->server,
                'port' => $this->emailInfo?->port,
                'username' => $this->emailInfo?->username,
                'password' => $this->emailInfo?->password,
            ],
            'redirection_info' => [
                'login' => $this->redirectionInfo?->login,
                'logout' => $this->redirectionInfo?->logout,
            ],
            'permitted_domains' => $this->permittedDomains->where('is_internal', 0)->pluck('domain')->toArray(),
            'jwt_expiration' => $this->jwtConfig->pluck('value')->toArray(),
        ];
    }
}
