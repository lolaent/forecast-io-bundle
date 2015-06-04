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

    protected $apiKey;

    /**
     * Class constructor
     *
     * @param ClientInterface     $client
     * @param SerializerInterface $serializer
     * @param string              $apiKey
     */
    public function __construct(ClientInterface $client, SerializerInterface $serializer = null, $apiKey)
    {
        $this->client = $client;
        $this->serializer = $serializer;
        $this->apiKey = $apiKey;
    }

    /**
     * @param float $latitude
     * @param float $longitude
     * @return mixed
     */
    public function getForecast($latitude, $longitude) {
        $url = sprintf(
            'https://api.forecast.io/forecast/%s/%s,%s',
            $this->apiKey,
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

    /**
     * Returns the forecast at a given time
     *
     * @param int    $latitude
     * @param int    $longitude
     * @param string $time
     * @return Response
     */
    public function getForecastByTime($latitude, $longitude, $time)
    {
        $url = sprintf(
            'https://api.forecast.io/forecast/%s/%s,%s,%s?exclude=minutely,flags,alerts',
            $this->apiKey,
            $latitude,
            $longitude,
            $time
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
