<?php

namespace App\Models;

use App\Models\Conversation;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatAssistant extends Model
{
    use HasFactory, BelongsToTenant;


  public function chat()
  {
    return $this->hasMany(Chat::class, 'chat_assistant_id');
  }

  public function traindata()
  {
    return $this->hasMany(AiInstruction::class, 'chat_assistant_id');
  }

  public function formfields()
  {
    return $this->hasMany(FormField::class, 'chat_assistant_id');
  }
  public function user()
  {
    return $this->belongsTo(User::class);
  }

}
