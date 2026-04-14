<?php

namespace App\Models;


use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory, BelongsToTenant;

    public $timestamps = false;

    protected $fillable = [
        'tenant_id',
        'name',
        'subtitle',
        'price',
        'type',
        'credits',
        'max_bots',
        'features',
        'status',
    ];
    /**
     * Plan can have many subscribers
     *
     */
    public function subscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }
}
