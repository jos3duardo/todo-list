<?php

namespace App\Service;

use App\Models\StickyNote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StickyNoteService
{

    public function validateStickyNote(Request $request){
        return Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
        ]);
    }

    public function createStickyNote(Request $request){
        $user = $request->user();
        $stickyNote = new StickyNote();
        $stickyNote->title = $request->title;
        $stickyNote->user_id = $user->id;
        $stickyNote->save();
        return $stickyNote;
    }

    public function updateStickyNote(Request $request, StickyNote $stickyNote){
        $user = $request->user();
        $stickyNote->fill($request->all());
        $stickyNote->user_id = $user->id;
        $stickyNote->save();

        return $stickyNote;
    }
}
