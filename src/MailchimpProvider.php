<?php

namespace YourFightSite\Socialite\Mailchimp;

use Illuminate\Support\Arr;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;

class MailchimpProvider extends AbstractProvider implements ProviderInterface
{
    /**
     * {@inheritDoc}
     */
    protected $stateless = true;

    /**
     * {@inheritDoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase('https://login.mailchimp.com/oauth2/authorize', $state);
    }

    /**
     * {@inheritDoc}
     */
    protected function getTokenUrl()
    {
        return 'https://login.mailchimp.com/oauth2/token';
    }

    /**
     * {@inheritDoc}
     */
    protected function getTokenFields($code)
    {
        return [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'code' => $code,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $this->redirectUrl,
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get('https://login.mailchimp.com/oauth2/metadata', [
            'headers' => [
                'Authorization' => 'OAuth '.$token,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * {@inheritDoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id' => Arr::get($user, 'user_id'),
            'nickname' => Arr::get($user, 'accountname'),
            'name' => $user['accountname'],
            'email' => Arr::get($user, 'login.email'),
            'avatar' => Arr::get($user, 'login.avatar'),
        ]);
    }

    /**
     * {@inheritDoc}
     */
    protected function getCodeFields($state = null)
    {
        return [
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUrl,
            'response_type' => 'code',
        ];
    }
}
