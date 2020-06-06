<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Service\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    private $categoryService;

    /**
     * CategoryController constructor.
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

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
            $validate = $validate = $this->categoryService->validateCategory($request);;
            if ($validate->fails()){
                return [
                    "status" => false,
                    "errors" => $validate->errors()
                ];
            }
            $category = $this->categoryService->createCategory($request);
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
            $validate = $this->categoryService->validateCategory($request);
            if ($validate->fails()){
                return [
                    "status" => false,
                    "errors" => $validate->errors()
                ];
            }
            $category = $this->categoryService->createCategory($request);
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
