<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use DateTime;
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {

    Gate::define('admin', function (User $user) {
      return $user->role == 'admin';
    });

    Gate::define('editor', function (User $user) {
      return $user->role == 'editor';
    });

    Gate::define('author', function (User $user) {
      return $user->role == 'author';
    });
  }
}
