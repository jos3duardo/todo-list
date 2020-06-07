<?php

namespace App\Models;

use App\Tenant\TenantModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes, TenantModels;

    protected $fillable = [
        'title', 'date','user_id','category_id','sticky_notes_id'
    ];

    public function getCreatedAtAttribute(){
        if ($this->attributes['created_at'] != null)
            return (new \DateTime($this->attributes['created_at']))->format('d/m/Y \\à\\s H\\hi');
        else
            return "";
    }

    public function getUpdatedAtAttribute(){
        if ($this->attributes['updated_at'] != null)
            return (new \DateTime($this->attributes['updated_at']))->format('d/m/Y \\à\\s H\\hi');
        else
            return "";
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function stickynote(){
        return $this->belongsTo(StickyNote::class);
    }
}
