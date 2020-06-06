<?php


namespace App\Service;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryService
{

    public function validateCategory(Request $request){
        $user = $request->user();
        return Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
        ]);
    }


    public function createCategory(Request $request){
        $user = $request->user();
        $category = Category::firstOrCreate([
        'name' => $request->name,
        'user_id' => $user->id
        ]);
        return $category;
    }

    public function updateCategory(Request $request, Category $category){
        $user = $request->user();
        $category->fill($request->all());
        $category->user_id = $user->id;
        $category->save();

        return $category;
    }
}
