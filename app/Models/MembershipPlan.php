<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MembershipPlan extends Model
{
    protected $table = 'membership_plans';

    protected $fillable = [
        'plan_name',
        'price',
        'duration_months',
        'description',
        'is_active',
    ];

    public static function getAllPlans()
    {
        return self::orderBy('price')->get();
    }

    public static function getActivePlans()
    {
        return self::where('is_active',1)
            ->orderBy('price')
            ->get();
    }

    public static function getPlanById($id)
    {
        return self::findOrFail($id);
    }

    public static function createPlan(array $data)
    {
        return self::create($data);
    }

    public static function updatePlan($id, array $data)
    {
        return self::findOrFail($id)->update($data);
    }

    public static function deletePlan($id)
    {
        return self::findOrFail($id)->delete();
    }

    /**
     * Scope to get active membership plans
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    /**
     * Scope to order plans by price
     */
    public function scopeOrderPrice($query)
    {
        return $query->orderBy('price');
    }
}