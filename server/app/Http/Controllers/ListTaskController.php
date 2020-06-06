<?php

namespace App\Http\Controllers;

use App\Http\Resources\ListTaskResource;
use App\Models\ListTask;
use App\Service\ListTaskService;
use Illuminate\Http\Request;

class ListTaskController extends Controller
{
    private $listTaskService;

    /**
     * TaskController constructor.
     * @param ListTaskService $listTaskService
     */
    public function __construct(ListTaskService $listTaskService)
    {
        $this->listTaskService = $listTaskService;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        try {
            return ['status' => true , 'data' => ListTaskResource::collection(ListTask::all())];
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
            $validate = $validate = $this->listTaskService->validateListTask($request);;
            if ($validate->fails()){
                return [
                    "status" => false,
                    "errors" => $validate->errors()
                ];
            }
            $listTask = $this->listTaskService->createListTask($request);
            return ['status' => true , 'data' => new ListTaskResource($listTask)];
        }catch (\Exception $err){
            return $err->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param ListTask $listTask
     */
    public function show(ListTask $listTask)
    {
        try {
            return ['status' => true , 'data' => new ListTaskResource($listTask)];
        }catch (\Exception $err){
            return $err->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ListTask $listTask
     */
    public function update(Request $request, ListTask $listTask)
    {
        try {
            $validate = $this->listTaskService->validateUpdateListTask($request, $listTask);
            if ($validate->fails()){
                return [
                    "status" => false,
                    "errors" => $validate->errors()
                ];
            }
            $listListTask = $this->listTaskService->updateListTask($request, $listTask);
            return ['status' => true , 'data' => new ListTaskResource($listTask)];
        }catch (\Exception $err){
            return $err->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ListTask $listTask
     */
    public function destroy(ListTask $listTask)
    {
        try {
            if(!$listTask->delete()){
                return [
                    "status" => false,
                    "errors" => 'Lista de Tarefa não pode ser apagada.'
                ];
            }
            return [
                "status" => true,
                "message" => 'Lista de Tarefa apagada.'
            ];
        }catch (\Exception $err){
            return $err->getMessage();
        }
    }
}
