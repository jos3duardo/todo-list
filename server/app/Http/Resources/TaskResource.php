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
            'inicio' => $this->date,
            'fim' => $this->date_stop,
            'usuario' => $this->user->name,
            'texto' => $this->text,
            'categoria' => $this->category->name,
            'status'=> $this->status == 1 ? 'Em andamento' : 'Finalizada',
            'lembretes' => StickyNotesResource::collection($this->stickynote)
        ];
    }
}
