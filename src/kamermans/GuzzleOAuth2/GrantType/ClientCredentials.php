<?php namespace kamermans\GuzzleOAuth2\GrantType;

use kamermans\GuzzleOAuth2\TokenData;

use GuzzleHttp\Collection;
use GuzzleHttp\ClientInterface;
use GuzzleHttpException\RequestException;

/**
 * Client credentials grant type.
 * @link http://tools.ietf.org/html/rfc6749#section-4.4
 */
class ClientCredentials implements GrantTypeInterface
{
    /** @var ClientInterface The token endpoint client */
    protected $client;

    /** @var Collection Configuration settings */
    protected $config;

    public function __construct(ClientInterface $client, $config)
    {
        $this->client = $client;
        $this->config = Collection::fromConfig($config,
            [
                'grant_type' => 'client_credentials',
                'client_secret' => '',
                'scope' => '',
            ], 
            [
                'client_id',
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getTokenData()
    {
        $response = $this->client->post(null, ['body' => $this->config->toArray()]);
        return new TokenData($response->json());
    }
}