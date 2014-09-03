<?php

// fixes Doctrine\Common\Annotations\AnnotationException: [Semantical Error] The annotation "@JMS\Serializer\Annotation\Type" in property CTI\ForecastBundle\Forecast\Response::$latitude does not exist, or could not be auto-loaded.
\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');

class ForecastManagerTest extends PHPUnit_Framework_TestCase
{

    public function testGetData() {
        $client = new \GuzzleHttp\Client();
        $mock = new \GuzzleHttp\Subscriber\Mock(
            array(
                file_get_contents(__DIR__ . '/Resources/forecast.txt')
            )
        );
        $client->getEmitter()->attach($mock);

        $namingStrategy = new \JMS\Serializer\Naming\SerializedNameAnnotationStrategy(new \JMS\Serializer\Naming\CamelCaseNamingStrategy());
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

        $manager = new \CTI\ForecastBundle\ForecastManager($client, $serializer);
        $data = $manager->getForecast(37.8267, -122.423);

        /** @var $data \CTI\ForecastBundle\Forecast\Response */

        $this->assertObjectHasAttribute('latitude', $data);
        $this->assertEquals(37.8267, $data->getLatitude());
        $this->assertObjectHasAttribute('longitude', $data);
        $this->assertEquals(-122.423, $data->getLongitude());
        $this->assertObjectHasAttribute('offset', $data);
        $this->assertEquals(-7, $data->getOffset());

        $this->assertObjectHasAttribute('minutely', $data);
        $this->assertInstanceOf('CTI\ForecastBundle\Forecast\DataBlock', $data->getMinutely());
        $this->assertInternalType('array', $data->getMinutely()->getData());
        $this->assertEquals(61, count($data->getMinutely()->getData()));
    }

}
