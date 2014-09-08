<?php

namespace CTI\ForecastBundle;

use CTI\ForecastBundle\Forecast\DataPoint;
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

    /**
     * Obtain weather conditions for the specified day
     *
     * @param int    $latitude
     * @param int    $longitude
     * @param string $dateTime E.g: 2014-05-06T12:00:00
     *
     * @return DataPoint
     */
    public function getDailyWeatherDetails($latitude, $longitude, $dateTime)
    {
        $url = sprintf(
            'https://api.forecast.io/forecast/%s/%s,%s,%s?exclude=minutely,hourly,flags,alerts,currently',
            'e711d8782f6c4c7a7e9c8335721bacde',
            $latitude,
            $longitude,
            $dateTime
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
        /** @var \CTI\ForecastBundle\Forecast\Response $result */
        $result = $this->serializer->deserialize(
            $response->getBody(),
            'CTI\ForecastBundle\Forecast\Response',
            'json'
        );

        if (empty($result)) {
            return new DataPoint();
        }

        return reset($result->getDaily()->getData());
    }

    /**
     * Obtain weather conditions for the specified hour
     *
     * @param int    $latitude
     * @param int    $longitude
     * @param string $dateTime E.g: 2014-05-06T12:00:00
     *
     * @return DataPoint
     */
    public function getHourlyWeatherDetails($latitude, $longitude, $dateTime)
    {
        $url = sprintf(
            'https://api.forecast.io/forecast/%s/%s,%s,%s?exclude=minutely,daily,flags,alerts,currently',
            'e711d8782f6c4c7a7e9c8335721bacde',
            $latitude,
            $longitude,
            $dateTime
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
        /** @var \CTI\ForecastBundle\Forecast\Response $result */
        $result = $this->serializer->deserialize(
            $response->getBody(),
            'CTI\ForecastBundle\Forecast\Response',
            'json'
        );

        if (empty($result)) {
            return new DataPoint();
        }

        foreach ($result->getHourly()->getData() as $dataPoint) {
            /** @var DataPoint $dataPoint */
            $forecastTime = \DateTime::createFromFormat( 'U', $dataPoint->getTime(), new \DateTimeZone('GMT'));
            $searchTime = new \DateTime($dateTime, new \DateTimeZone('GMT'));
            if ($forecastTime == $searchTime) {
                return $dataPoint;
            }
        }

        return new DataPoint();
    }

}
