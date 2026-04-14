<?php

namespace App\Policies;

use App\Models\AiInstruction;
use App\Models\User;

class TrainPolicy
{

  public function update(User $user, AiInstruction $train)
  {
    return $user->id === $train->user_id;
  }

  public function delete(User $user, AiInstruction $train)
  {
    return $user->id === $train->user_id;
  }
}
