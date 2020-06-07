<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Service\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private $taskService;

    /**
     * TaskController constructor.
     * @param TaskService $taskService
     */
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            return ['status' => true , 'data' => TaskResource::collection(Task::user($user->id)->get())];
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
            $validate = $validate = $this->taskService->validateTask($request);;
            if ($validate->fails()){
                return [
                    "status" => false,
                    "errors" => $validate->errors()
                ];
            }
            $task = $this->taskService->createTask($request);
            return ['status' => true , 'data' => new TaskResource($task)];
        }catch (\Exception $err){
            return $err->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Task $task
     */
    public function show(Task $task)
    {
        try {
            return ['status' => true , 'data' => new TaskResource($task)];
        }catch (\Exception $err){
            return $err->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Task $task
     */
    public function update(Request $request, Task $task)
    {
        try {
            $validate = $this->taskService->validateUpdateTask($request, $task);
            if ($validate->fails()){
                return [
                    "status" => false,
                    "errors" => $validate->errors()
                ];
            }
            $task = $this->taskService->updateTasnk($request, $task);
            return ['status' => true , 'data' => new TaskResource($task)];
        }catch (\Exception $err){
            return $err->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     */
    public function destroy(Task $task)
    {
        try {
            if(!$task->delete()){
                return [
                    "status" => false,
                    "errors" => 'Tarefa não pode ser apagada.'
                ];
            }
            return [
                "status" => true,
                "message" => 'Tarefa apagada.'
            ];
        }catch (\Exception $err){
            return $err->getMessage();
        }
    }
}
