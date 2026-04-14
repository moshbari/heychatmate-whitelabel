<?php

namespace App\Models;


use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory, BelongsToTenant;

    public $timestamps = false;
    /**
     * Plan can have many subscribers
     *
     */
    public function subscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }
}
