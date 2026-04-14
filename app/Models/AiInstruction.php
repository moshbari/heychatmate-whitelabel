<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiInstruction extends Model
{
    use HasFactory;

    protected $table = "ai_instructions";

  public function assistant()
  {
    return $this->belongsTo(ChatAssistant::class);
  }
}
