<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'conversation_id' => $this->conversation_id,
            'messageable_id' => $this->messageable_id,
            'messageable_type' => $this->messageable_type,
            'body' => $this->body,
            'attachment' => $this->attachment,
            'messageable' => [
                'id' => $this->messageable->id,
                'name' => $this->messageable->name ?? $this->messageable->full_name,
                'avatar' => $this->messageable->avatar,
            ],
            'conversation' => new ConversationResource($this->whenLoaded('conversation')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}