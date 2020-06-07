<?php

namespace App\Observers;

use App\Category;
use App\Models\Task;

class CategoryObserver
{
    /**
     * Handle the category "created" event.
     *
     * @param  \App\Category  $category
     * @return void
     */
    public function created(Category $category)
    {
        //
    }

    /**
     * Handle the category "updated" event.
     *
     * @param  \App\Category  $category
     * @return void
     */
    public function updated(Category $category)
    {
        //
    }

    /**
     * Handle the category "deleted" event.
     *
     * @param  \App\Category  $category
     * @return void
     */
    public function deleted(Category $category)
    {
        $tasks = Task::where([
            'category_id' => $category->id
        ])->get();

        $firstCategory = Category::where([
            'user_id' => $category->user_id
        ])->first();

        if ($tasks){
            foreach ($tasks as $task){
                $task->category_id = $firstCategory->id;
                $task->save();
            }
        }
    }

    /**
     * Handle the category "restored" event.
     *
     * @param  \App\Category  $category
     * @return void
     */
    public function restored(Category $category)
    {
        //
    }

    /**
     * Handle the category "force deleted" event.
     *
     * @param  \App\Category  $category
     * @return void
     */
    public function forceDeleted(Category $category)
    {
        //
    }
}
