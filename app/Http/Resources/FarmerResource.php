<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FarmerResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $avatarFile = $this->avatar ?: 'default.webp';

        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'location'   => $this->location,
            'contact'    => $this->contact,
            'bio'        => $this->bio,
            'avatar_url' => $request->getSchemeAndHttpHost() . '/img/farmers/' . $avatarFile,
            'created_at' => optional($this->created_at)->toIso8601String(),
        ];
    }
}
