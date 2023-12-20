<?php

namespace SpiralOver\Mailer\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use SpiralOver\Mailer\Client\Exceptions\RequestFailureException;

class Mailer
{
    use ClientTrait;

    public const API_VERSION = 'v1';
    public const SERVER_LOCAL = 'http://192.168.103.1:4401';
    public const SERVER_SPIRALOVER = 'https://mailer.spiralover.com';


    private readonly Client $client;


    /**
     * @param string $authToken Authentication Token / Personal Access Token
     * @param string $server Server Web Address
     * @param string $apiVersion
     * @return static
     */
    public static function client(
        string $authToken,
        string $server = Mailer::SERVER_LOCAL,
        string $apiVersion = Mailer::API_VERSION,
    ): Mailer
    {
        return new static(authToken: $authToken, server: $server, apiVersion: $apiVersion);
    }

    public function __construct(
        private readonly string $authToken,
        private readonly string $server,
        private readonly string $apiVersion,
    )
    {
        $this->client = new Client([
            'base_uri' => sprintf('%s/api/%s/', $this->server, $this->apiVersion),
        ]);
    }


    /**
     * @param string $appId
     * @param array $mails
     * @param string|null $callback
     * @param bool $callbackOnSuccess Weather to call you back when the webhook accept this impulse
     * @param bool $callbackOnFailure Weather to call you back when the webhook reject this impulse or throws error handling it
     * @return string
     * @throws GuzzleException
     * @throws RequestFailureException
     */
    public function send(
        string  $appId,
        array   $mails,
        ?string $callback = null,
        bool    $callbackOnSuccess = false,
        bool    $callbackOnFailure = false,
    ): string
    {
        $this->withData([
            'mails' => $mails,
            'callback' => $callback,
            'callback_on_success' => $callbackOnSuccess,
            'callback_on_failure' => $callbackOnFailure,
        ]);

        $response = MailerResponse::new(response: $this->client->post(
            uri: sprintf('applications/%s/mails', $appId),
            options: $this->getClientOptions(),
        ));

        return $response->message();
    }
}