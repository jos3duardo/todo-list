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
            'data inicio' => $this->date,
            'data conclusão' => $this->date_stop,
            'usuario' => $this->user->name,
            'categoria' => $this->category->name,
            'lembretes' => $this->stickynote
        ];
    }
}
