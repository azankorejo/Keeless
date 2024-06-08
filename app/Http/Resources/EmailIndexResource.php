<?php

namespace App\Http\Resources;

use App\Models\BusinessInformation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmailIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $answers = $this->getFormattedStrings($this->answers);
        return [
            'code' => $this->code,
            'name' => $this->name,
            'answers' => $answers,
        ];
    }

    private function getFormattedStrings(string $answers): string
    {
        $result = $answers;
        $businessDetails = BusinessInformation::query()->first();
        if(str_contains($answers, '{{$')) {
            $result = str_replace('{{$appName}}', $businessDetails?->name ?? 'app', $result);
            $result = str_replace('{{$email}}', $businessDetails?->support_email ?? auth()->user()->email, $result);
            $result = str_replace('{{$website}}', $businessDetails?->web_url ?? 'website', $result);
        }
        return $result;
    }
}
