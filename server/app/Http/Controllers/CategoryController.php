<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        try {
            return ['status' => true , 'data' =>  Category::all()];
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
            $user = $request->user();
            $data = $request->all();
            $validate = Validator::make($data, [
                'name' => ['required', 'string', 'max:255','unique:categories'],
            ]);

            if ($validate->fails()){
                return [
                    "status" => false,
                    "errors" => $validate->errors()
                ];
            }

            $category = new Category();
            $category->name = $request->name;
            $category->user_id = $user->id;
            $category->save();
            return ['status' => true , 'data' =>  $category];
        }catch (\Exception $err){
            return $err->getMessage();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     */
    public function show(Category $category)
    {
        try {
            return ['status' => true , 'data' =>  $category];
        }catch (\Exception $err){
            return $err->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category $category
     */
    public function update(Request $request, Category $category)
    {
        try {
            return ['status' => true , 'data' =>  $category];
        }catch (\Exception $err){
            return $err->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     */
    public function destroy(Category $category)
    {
        try {
            if($category->delete()){
                return [
                    "status" => false,
                    "errors" => 'A categoria não pode ser apagada.'
                ];
            }
            return [
                "status" => true,
                "message" => 'Categoria apagada.'
            ];
        }catch (\Exception $err){
            return $err->getMessage();
        }
    }
}
