# Mailchimp provider for Laravel Socialite
A Mailchimp provider for [Laravel Socialite][1].

## Installation
This package can be installed using [Composer][2]:

```
composer require yourfightsite/mailchimp-socialite-provider
```

## Usage
This package adds a Socialite provider that can be used using the `mailchimp` key:

```php
/**
 * Redirect the user to the Mailchimp authentication page.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  \App\Website  $website
 * @return \Illuminate\Http\Response
 */
public function redirectToProvider(Request $request, Website $website)
{
    return Socialite::driver('mailchimp')->redirect();
}

/**
 * Obtain the user information from Mailchimp.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
public function handleProviderCallback(Request $request)
{
    $user = Socialite::driver('mailchimp')->user();
}
```

## License
Licensed under the [MIT License](LICENSE.md).

[1]: https://github.com/laravel/socialite
[2]: https://getcomposer.org
[3]: https://mailchimp.com/developer/api/marketing/
