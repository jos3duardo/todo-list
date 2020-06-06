<?php

namespace App\Http\Controllers;

use App\Http\Resources\StickyNotesResource;
use App\Models\StickyNote;
use App\Service\StickyNoteService;
use Illuminate\Http\Request;

class StickyNoteController extends Controller
{
    private $stickyNoteService;

    /**
     * StickyNotesController constructor.
     * @param StickyNoteService $stickyNoteService
     */
    public function __construct(StickyNoteService $stickyNoteService)
    {
        $this->stickyNoteService = $stickyNoteService;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            return ['status' => true , 'data' =>  StickyNotesResource::collection(StickyNote::user($user->id)->get())];
        }catch (\Exception $err){
            return $err->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        try {
            $validate = $validate = $this->stickyNoteService->validateStickyNote($request);;
            if ($validate->fails()){
                return [
                    "status" => false,
                    "errors" => $validate->errors()
                ];
            }
            $stickyNote = $this->stickyNoteService->createStickyNote($request);
            return ['status' => true , 'data' => new StickyNotesResource($stickyNote)];
        }catch (\Exception $err){
            return $err->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param StickyNote $stickyNote
     */
    public function show(StickyNote $stickyNote)
    {
        try {
            return ['status' => true , 'data' => new StickyNotesResource($stickyNote)];
        }catch (\Exception $err){
            return $err->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param StickyNote $stickyNote
     */
    public function update(Request $request, StickyNote $stickyNote)
    {
        try {
            $validate = $this->stickyNoteService->validateStickyNote($request);
            if ($validate->fails()){
                return [
                    "status" => false,
                    "errors" => $validate->errors()
                ];
            }
            $stickyNote = $this->stickyNoteService->updateStickyNote($request, $stickyNote);
            return ['status' => true , 'data' => new StickyNotesResource($stickyNote)];
        }catch (\Exception $err){
            return $err->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param StickyNote $stickyNote
     */
    public function destroy(StickyNote $stickyNote)
    {
        try {
            if(!$stickyNote->delete()){
                return [
                    "status" => false,
                    "errors" => 'Lembrete não pode ser apagado.'
                ];
            }
            return [
                "status" => true,
                "message" => 'Lembrete apagado.'
            ];
        }catch (\Exception $err){
            return $err->getMessage();
        }
    }
}
