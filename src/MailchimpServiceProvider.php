<?php

namespace YourFightSite\Socialite\Mailchimp;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use YourFightSite\Socialite\Mailchimp\MailchimpProvider;

class MailchimpServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Socialite::extend('mailchimp', function (Application $app) {
            $config = $app['config']['services.mailchimp'];

            $redirect = $config['redirect'];
            $redirect = Str::startsWith($redirect, '/') ? $app->make('url')->to($redirect, [], true) : $redirect;

            return new MailchimpProvider(
                $app->make('request'),
                $config['client_id'],
                $config['client_secret'],
                $redirect
            );
        });
    }
}
