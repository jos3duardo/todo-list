<?php


namespace App\Service;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TaskService
{

    public function validateTask(Request $request){
        return Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255','unique:tasks'],
            'date' => ['required'],
            'category_id' => ['required'],
        ]);
    }

    public function validateUpdateTask(Request $request, Task $task){
        return Validator::make($request->all(), [
            'title' => ['required','string','max:255', Rule::unique('tasks')->ignore($task->id)],
            'date' => ['required'],
            'category_id' => ['required'],
        ]);
    }

    public function createTask(Request $request){
        $user = $request->user();
        $task = new Task();
        $task->title = $request->title;
        $task->date = dateParse($request->date);
        $task->category_id = $request->category_id;
        $task->user_id = $user->id;
        $task->save();
        return $task;
    }

    public function updateTasnk(Request $request, Task $task){
        $task->fill($request->all());
        $task->save();

        return $task;
    }

}
