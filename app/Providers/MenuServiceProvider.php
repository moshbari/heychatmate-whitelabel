<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot()
  {
    $verticalMenuJson = file_get_contents(base_path('resources/menu/verticalMenuUser.json'));
    $verticalMenuData = json_decode($verticalMenuJson);

    $verticalMenuAdminJson = file_get_contents(base_path('resources/menu/verticalMenuAdmin.json'));
    $verticalMenuAdmin = json_decode($verticalMenuAdminJson);

    // Share all menuData to all the views
    \View::share('menuData', [$verticalMenuData]);
    \View::share('menuDataAdmin', [$verticalMenuAdmin]);
  }
}
