<?php

namespace App\Models;

use App\Models\Conversation;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
  use HasFactory, BelongsToTenant;

  protected $table = "chats";

  public function conversations()
  {
    return $this->hasMany(Conversation::class, 'chat_id');
  }


  public function assistant()
  {
    return $this->belongsTo(ChatAssistant::class, 'chat_assistant_id');
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

}
