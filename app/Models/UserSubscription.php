<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;


    protected $casts = [
        'due_date' => 'datetime'
    ];

    /**
     * Subscription belongs to a single user
     *
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Plan belongs to a single user
     *
     *
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function isActive()
    {
        return $this->due_date->gt(now());
    }
}
