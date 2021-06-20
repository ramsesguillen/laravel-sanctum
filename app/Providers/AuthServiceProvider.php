<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        VerifyEmail::toMailUsing(function( $notifiable, $url ) {
            // $spaUrl = "http://127.0.0.1:8000?email_verify_url=".$url;
            return( new MailMessage )
                    ->subject('Verify Email Address :)')
                    ->line('Click the button below to verfy your email address')
                    ->action('Veridy Email Address', $url);
        });
    }
}
