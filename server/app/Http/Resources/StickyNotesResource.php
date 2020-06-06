<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StickyNotesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'titulo' => $this->title,
            'tarefa' => $this->task->title,
            'usuario' => $this->user->name
        ];
    }
}
