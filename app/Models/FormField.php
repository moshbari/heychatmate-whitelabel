<?php

namespace App\Models;

use App\Models\Conversation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormField extends Model
{
  use HasFactory;
  
  public function assistant()
  {
    return $this->belongsTo(ChatAssistant::class, 'chat_assistant_id');
  }
}
