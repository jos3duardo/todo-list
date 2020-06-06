<?php


namespace App\Tenant;


trait TenantModels
{
    public function scopeUser($query, $id)
    {
        return $query->where('user_id', $id);
    }
}
