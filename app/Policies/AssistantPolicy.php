<?php

namespace App\Policies;

use App\Models\ChatAssistant;
use App\Models\User;

class AssistantPolicy
{

  public function update(User $user, ChatAssistant $assistant): bool
  {
    return $user->id === $assistant->user_id;
  }

  public function delete(User $user, ChatAssistant $assistant): bool
  {
    return $user->id === $assistant->user_id;
  }

  public function view(User $user, ChatAssistant $assistant): bool
  {
    return $user->id === $assistant->user_id;
  }
}
