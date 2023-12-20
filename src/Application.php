<?php

namespace SpiralOver\Mailer\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use SpiralOver\Mailer\Client\Dto\ApplicationDto;
use SpiralOver\Mailer\Client\Exceptions\RequestFailureException;

class Application
{
    use ClientTrait;

    public const API_VERSION = 'v1';
    public const SERVER_LOCAL = 'http://localhost:4301';
    public const SERVER_SPIRALOVER = 'https://nerve.spiralover.com';


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
    ): static
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
     * @return ApplicationDto[]
     * @throws RequestFailureException
     * @throws GuzzleException
     */
    public function list(): array
    {
        $response = MailerResponse::new(response: $this->client->get(
            uri: 'applications',
            options: $this->getClientOptions(),
        ));

        $applications = [];
        foreach ($response->data() as $application) {
            $applications[] = ApplicationDto::from($application);
        }

        return $applications;
    }

    /**
     * @param string $id
     * @return ApplicationDto
     * @throws GuzzleException
     * @throws RequestFailureException
     */
    public function read(string $id): ApplicationDto
    {
        $response = MailerResponse::new(response: $this->client->get(
            uri: sprintf('applications/%s', $id),
            options: $this->getClientOptions(),
        ));

        return ApplicationDto::from($response->data());
    }

    /**
     * @param string $id
     * @return string
     * @throws GuzzleException
     * @throws RequestFailureException
     */
    public function delete(string $id): string
    {
        $response = MailerResponse::new(response: $this->client->delete(
            uri: sprintf('applications/%s', $id),
            options: $this->getClientOptions(),
        ));

        return $response->message();
    }

    /**
     * @param string $name
     * @param string $url
     * @param string $webhook
     * @param string $desc
     * @return ApplicationDto
     * @throws GuzzleException
     * @throws RequestFailureException
     */
    public function create(string $name, string $url, string $webhook, string $desc): ApplicationDto
    {
        $this->withData([
            'name' => $name,
            'url' => $url,
            'webhook' => $webhook,
            'description' => $desc,
        ]);

        $response = MailerResponse::new(response: $this->client->post(
            uri: 'applications',
            options: $this->getClientOptions(),
        ));

        return ApplicationDto::from($response->data());
    }

    /**
     * @param string $id
     * @param string $name
     * @param string $url
     * @param string $webhook
     * @param string $desc
     * @return ApplicationDto
     * @throws GuzzleException
     * @throws RequestFailureException
     */
    public function update(string $id, string $name, string $url, string $webhook, string $desc): ApplicationDto
    {
        $this->withData([
            'name' => $name,
            'url' => $url,
            'webhook' => $webhook,
            'description' => $desc,
        ]);

        $response = MailerResponse::new(response: $this->client->put(
            uri: sprintf('applications/%s', $id),
            options: $this->getClientOptions(),
        ));

        return ApplicationDto::from($response->data());
    }
}