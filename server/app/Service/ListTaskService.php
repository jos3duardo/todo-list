<?php

namespace App\Service;

use App\Models\ListTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ListTaskService
{
    public function validateListTask(Request $request){
        return Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255','unique:list_tasks'],
        ]);
    }

    public function validateUpdateListTask(Request $request, ListTask $listTask){
        return Validator::make($request->all(), [
           'title' => ['required','string','max:255', Rule::unique('tasks')->ignore($listTask->id)]
        ]);
    }

    public function createListTask(Request $request){
        $user = $request->user();
        $listTask = new ListTask();
        $listTask->title = $request->title;
        $listTask->user_id = $user->id;
        $listTask->save();
        return $listTask;
    }

    public function updateListTask(Request $request, ListTask $listTask){
        $user = $request->user();
        $listTask->fill($request->all());
        $listTask->user_id = $user->id;
        $listTask->save();

        return $listTask;
    }
}
