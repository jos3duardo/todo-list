<?php

namespace App\Models;

use App\Tenant\TenantModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListTask extends Model
{
    use SoftDeletes, TenantModels;

    protected $fillable = [
        'title', 'user_id'
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
    public function task(){
        return $this->hasMany(Task::class);
    }
}
