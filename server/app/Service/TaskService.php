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
            'category_id' => ['required'],
        ]);
    }

    public function validateUpdateTask(Request $request, Task $task){
        return Validator::make($request->all(), [
            'title' => ['required','string','max:255'],
            'date' => ['required'],
            'category_id' => ['required']
        ]);
    }

    public function createTask(Request $request){
        $user = $request->user();
        $task = Task::firstOrCreate([
            'title' => $request->title,
            'date' => dateParse($request->date),
            'category_id' => $request->category_id,
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
