<?php

namespace App\Providers;

use App\Models\AiInstruction;
use App\Models\ChatAssistant;
use App\Policies\AssistantPolicy;
use App\Policies\TrainPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
  /**
   * The policy mappings for the application.
   *
   * @var array<class-string, class-string>
   */
  protected $policies = [
    // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    AiInstruction::class => TrainPolicy::class,
    ChatAssistant::class => AssistantPolicy::class,
  ];

  /**
   * Register any authentication / authorization services.
   *
   * @return void
   */
  public function boot()
  {
    $this->registerPolicies();

    //
  }
}
