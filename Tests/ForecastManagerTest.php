<?php

// fixes Doctrine\Common\Annotations\AnnotationException: [Semantical Error] The annotation "@JMS\Serializer\Annotation\Type" in property CTI\ForecastBundle\Forecast\Response::$latitude does not exist, or could not be auto-loaded.
\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');

class ForecastManagerTest extends PHPUnit_Framework_TestCase
{
    /** @var  \CTI\ForecastBundle\ForecastManager */
    public $manager;

    public function setUp()
    {
        $mockResponse = new \Guzzle\Http\Message\Response(200);
        $mockResponseBody = \Guzzle\Http\EntityBody::factory(fopen(
                __DIR__ . '/Resources/forecast.json', 'r')
        );
        $mockResponse->setBody($mockResponseBody);
        $plugin = new \Guzzle\Plugin\Mock\MockPlugin();
        $plugin->addResponse($mockResponse);
        $client = new \Guzzle\Http\Client();
        $client->addSubscriber($plugin);

        $namingStrategy = new \JMS\Serializer\Naming\SerializedNameAnnotationStrategy(new \JMS\Serializer\Naming\IdenticalPropertyNamingStrategy());
        $serializer = new \JMS\Serializer\Serializer(
            new Metadata\MetadataFactory(new \JMS\Serializer\Metadata\Driver\AnnotationDriver(new \Doctrine\Common\Annotations\AnnotationReader())),
            new \JMS\Serializer\Handler\HandlerRegistry(),
            new \JMS\Serializer\Construction\UnserializeObjectConstructor(),
            new \PhpCollection\Map(array(
                'json' => new \JMS\Serializer\JsonSerializationVisitor($namingStrategy),
                'xml'  => new \JMS\Serializer\XmlSerializationVisitor($namingStrategy),
                'yml'  => new \JMS\Serializer\YamlSerializationVisitor($namingStrategy),
            )),
            new \PhpCollection\Map(array(
                'json' => new \JMS\Serializer\JsonDeserializationVisitor($namingStrategy),
                'xml'  => new \JMS\Serializer\XmlDeserializationVisitor($namingStrategy),
            )),
            new \JMS\Serializer\EventDispatcher\EventDispatcher()
        );

        $this->manager = new \CTI\ForecastBundle\ForecastManager($client, $serializer);
    }

    public function testGetForecast() {

        $data = $this->manager->getForecast(37.8267, -122.423);

        /** @var $data \CTI\ForecastBundle\Forecast\Response */

        $this->assertObjectHasAttribute('latitude', $data);
        $this->assertEquals(37.8267, $data->getLatitude());
        $this->assertObjectHasAttribute('longitude', $data);
        $this->assertEquals(-122.423, $data->getLongitude());
        $this->assertObjectHasAttribute('offset', $data);
        $this->assertEquals(-7, $data->getOffset());

        $this->assertObjectHasAttribute('currently', $data);
        $this->assertInstanceOf('CTI\ForecastBundle\Forecast\DataPoint', $data->getCurrently());
        $this->assertEquals(1409688118, $data->getCurrently()->getTime());
        $this->assertEquals('Clear', $data->getCurrently()->getSummary());
        $this->assertEquals('clear-day', $data->getCurrently()->getIcon());
        $this->assertEquals(0, $data->getCurrently()->getPrecipIntensity());
        $this->assertEquals(0, $data->getCurrently()->getPrecipProbability());
        $this->assertEquals(63.37, $data->getCurrently()->getTemperature());

        $this->assertObjectHasAttribute('minutely', $data);
        $this->assertInstanceOf('CTI\ForecastBundle\Forecast\DataBlock', $data->getMinutely());
        $this->assertInternalType('array', $data->getMinutely()->getData());
        $this->assertEquals(61, count($data->getMinutely()->getData()));

        $this->assertObjectHasAttribute('hourly', $data);
        $this->assertInstanceOf('CTI\ForecastBundle\Forecast\DataBlock', $data->getHourly());
        $this->assertInternalType('array', $data->getHourly()->getData());
        $this->assertEquals(49, count($data->getHourly()->getData()));
        /** @var \CTI\ForecastBundle\Forecast\DataPoint $firstHour */
        $firstHour = reset($data->getHourly()->getData());
        $this->assertInstanceOf('CTI\ForecastBundle\Forecast\DataPoint', $firstHour);
        $this->assertEquals(1409688000, $firstHour->getTime());

        $this->assertObjectHasAttribute('daily', $data);
        $this->assertInstanceOf('CTI\ForecastBundle\Forecast\DataBlock', $data->getDaily());
        $this->assertInternalType('array', $data->getDaily()->getData());
        $this->assertEquals(8, count($data->getDaily()->getData()));
        /** @var \CTI\ForecastBundle\Forecast\DataPoint $firstDay */
        $firstDay = reset($data->getDaily()->getData());
        $this->assertInstanceOf('CTI\ForecastBundle\Forecast\DataPoint', $firstDay);
        $this->assertEquals(1409641200, $firstDay->getTime());
    }

    public function testGetDailyWeatherDetails()
    {
        $data = $this->manager->getDailyWeatherDetails(37.8267, -122.423, '2014-09-02T12:00:00');
        $this->assertInstanceOf('CTI\ForecastBundle\Forecast\DataPoint', $data);
        $this->assertObjectHasAttribute('icon', $data);
        $this->assertObjectHasAttribute('temperatureMin', $data);
        $this->assertObjectHasAttribute('temperatureMax', $data);
        $this->assertObjectHasAttribute('windSpeed', $data);
        $this->assertObjectHasAttribute('precipProbability', $data);
        $this->assertEquals(1409641200, $data->getTime());
        $this->assertEquals('fog', $data->getIcon());
        $this->assertEquals(58.36, $data->getTemperatureMin());
        $this->assertEquals(65.56, $data->getTemperatureMax());
        $this->assertEquals(7.67, $data->getWindSpeed());
        $this->assertEquals(0, $data->getPrecipProbability());
    }

    public function testGetHourlyWeatherDetails()
    {
        $data = $this->manager->getHourlyWeatherDetails(37.8267, -122.423, '2014-09-03T10:25:00');
        $this->assertInstanceOf('CTI\ForecastBundle\Forecast\DataPoint', $data);
        $this->assertObjectHasAttribute('time', $data);
        $this->assertObjectHasAttribute('icon', $data);
        $this->assertObjectHasAttribute('temperature', $data);
        $this->assertObjectHasAttribute('windSpeed', $data);
        $this->assertObjectHasAttribute('precipProbability', $data);
        $this->assertEquals(1409763600, $data->getTime());
        $this->assertEquals('partly-cloudy-day', $data->getIcon());
        $this->assertEquals(61.55, $data->getTemperature());
        $this->assertEquals(1.98, $data->getWindSpeed());
        $this->assertEquals(0, $data->getPrecipProbability());
    }

}
