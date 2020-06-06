<?php


namespace App\Service;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryService
{

    public function validateCategory(Request $request){
        return Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255','unique:categories'],
        ]);
    }


    public function createCategory(Request $request){
        $user = $request->user();
        $category = new Category();
        $category->name = $request->name;
        $category->user_id = $user->id;
        $category->save();
        return $category;
    }

}
