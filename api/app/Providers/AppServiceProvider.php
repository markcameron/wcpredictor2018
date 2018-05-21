<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Laravel\Passport\Passport;
use Laravel\Passport\Bridge\UserRepository;
use Laravel\Passport\Bridge\RefreshTokenRepository;
use App\Grants\SocialRequestGrant;
use League\OAuth2\Server\AuthorizationServer;

class AppServiceProvider extends ServiceProvider {

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot() {
    Schema::defaultStringLength(191);
    app(AuthorizationServer::class)->enableGrantType($this->makeSocialGrant(), Passport::tokensExpireIn());
  }

  /**
   * Register any application services.
   *
   * @return void
   */
  public function register() {
    //
  }

  /**
   * Create and configure a Password grant instance.
   *
   * @return PasswordGrant
   */
  protected function makeSocialGrant() {
    $grant = new SocialRequestGrant(
      $this->app->make(UserRepository::class),
      $this->app->make(RefreshTokenRepository::class)
    );

    $grant->setRefreshTokenTTL(Passport::refreshTokensExpireIn());

    return $grant;
  }

}
