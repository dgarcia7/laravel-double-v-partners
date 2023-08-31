<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'account' => new AccountResource($this->account),
            'product' => $this->product,
            'quantity' => $this->quantity,
            'value' => $this->value,
            'total' => $this->total,
            'status' => $this->status,
        ];
    }
}
