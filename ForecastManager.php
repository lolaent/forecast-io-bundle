<?php

namespace CTI\ForecastBundle;

use Guzzle\Http\ClientInterface;
use Guzzle\Http\Message\Response;
use JMS\Serializer\SerializerInterface;

class ForecastManager
{

    /**
     * @var \Guzzle\Http\ClientInterface the client used to make the connection
     */
    protected $client;

    /**
     * @var \JMS\Serializer\SerializerInterface
     */
    protected $serializer;

    /**
     * Class constructor
     *
     * @param ClientInterface $client
     * @param SerializerInterface $serializer
     */
    public function __construct(ClientInterface $client, SerializerInterface $serializer = null)
    {
        $this->client = $client;
        $this->serializer = $serializer;
    }

    /**
     * @param float $latitude
     * @param float $longitude
     * @return mixed
     */
    public function getForecast($latitude, $longitude) {
        $url = sprintf(
            'https://api.forecast.io/forecast/%s/%s,%s',
            'e711d8782f6c4c7a7e9c8335721bacde',
            $latitude,
            $longitude
        );

        $request = $this->client->createRequest(
            'GET',
            $url,
            array(
                'config' => array(
                    // prevents SSL certification problems on Yosemite
                    'curl' => array(
                        CURLOPT_SSL_VERIFYPEER => true,
                        CURLOPT_CAINFO         => __DIR__ . '/Resources/DigiCertGlobalRootCA',
                    )
                )
            )
        );

        /** @var Response $response */
        $response = $this->client->send($request);

        return $this->serializer->deserialize(
            $response->getBody(),
            'CTI\ForecastBundle\Forecast\Response',
            'json'
        );
    }

}
