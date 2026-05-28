<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
<<<<<<< HEAD
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
=======
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Laravel\Socialite\Facades\Socialite;

use SocialiteProviders\Manager\SocialiteWasCalled;
>>>>>>> 24a6c2c (feat: add TypeScript support and define auth types)

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    #public function boot(): void
    #{
    #    $this->configureDefaults();
#
    #    Socialite::extend('authentik', function ($app) {
    #        $config = $app['config']['services.authentik'];
    #        \Log::debug('Authentik config:', $config);
    #        return Socialite::buildProvider(
    #            \SocialiteProviders\Authentik\Provider::class,
    #            $config
    #        );
    #    });
    #}


    #public function boot(): void
    #{
    #    $this->configureDefaults();
#
    #    Socialite::extend('authentik', function ($app) {
    #        $config = $app['config']['services.authentik'];
    #        $provider = new \SocialiteProviders\Authentik\Provider(
    #            $app['request'],
    #            $config['client_id'],
    #            $config['client_secret'],
    #            $config['redirect']
    #        );
    #        
    #        $provider->setConfig($config);
    #        
    #        return $provider;
    #    });
    #}


    public function boot(): void
    {
        $this->configureDefaults();

        Event::listen(SocialiteWasCalled::class, function (SocialiteWasCalled $event) {
            $event->extendSocialite('authentik', \SocialiteProviders\Authentik\Provider::class);
        });
    }


    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
