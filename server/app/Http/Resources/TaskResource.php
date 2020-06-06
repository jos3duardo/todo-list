<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'data conclusão' => $this->created_at,
            'usuario' => $this->user->name,
            'categoria' => $this->category->name,
            'lembretes' => $this->stickynote
        ];
    }
}
