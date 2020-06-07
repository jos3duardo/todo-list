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
            'title' => ['required', 'string', 'max:255'],
        ]);
    }

    public function validateUpdateListTask(Request $request, ListTask $listTask){
        return Validator::make($request->all(), [
           'title' => ['required','string','max:255']
        ]);
    }

    public function createListTask(Request $request){
        $user = $request->user();
        $listTask = ListTask::firstOrCreate([
            'title' => $request->title,
            'user_id' => $user->id
        ]);
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
