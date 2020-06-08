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
            'title' => ['required', 'string', 'max:255'],
            'date' => ['required'],
            'date_stop' => ['required'],
            'text' => ['required'],
            'category_id' => ['required'],
            'list_task_id' => ['required'],
        ]);
    }

    public function validateUpdateTask(Request $request, Task $task){
        return Validator::make($request->all(), [
            'title' => ['required','string','max:255'],
            'date' => ['required'],
            'date_stop' => ['required'],
            'text' => ['required'],
            'list_task_id' => ['required'],
            'category_id' => ['required']
        ]);
    }

    public function createTask(Request $request){
        $user = $request->user();
        $task = Task::create([
            'title' => $request->title,
            'date' => dateParse($request->date),
            'date_stop' => dateParse($request->date_stop),
            'text' => $request->text,
            'category_id' => $request->category_id,
            'list_task_id' => $request->list_task_id,
            'user_id' => $user->id,
        ]);
        return $task;
    }

    public function updateTasnk(Request $request, Task $task){
        $task->fill($request->all());
        $task->save();

        return $task;
    }

}
