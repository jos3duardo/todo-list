<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StickyNote extends Model
{
    use SoftDeletes;

    protected $fillable = ['title'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

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
}
