<?php

namespace App\Http\Resources;

use App\Enums\LemonSqueezySubscriptionStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use LemonSqueezy\Laravel\Subscription;

/**
 * @mixin Subscription
 */
class SubscriptionResource extends JsonResource
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
            'status' => LemonSqueezySubscriptionStatusEnum::from($this->status)->getLabel(),
            'variant_id' => $this->variant_id,
            'card_brand' => $this->card_brand,
            'card_last_four' => $this->card_last_four,
            'pause_mode' => $this->pause_mode,
            'pause_resumes_at' => $this->pause_resumes_at,
            'trial_ends_at' => $this->trial_ends_at,
            'renews_at' => $this->renews_at,
            'ends_at' => $this->ends_at,
            'created_at' => $this->created_at,
        ];
    }
}
