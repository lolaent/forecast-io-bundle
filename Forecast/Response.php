<?php

/**
 * This file is part of the Forecast.io Symfony2 bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package CTI\ForecastBundle\Forecast
 * @author  Georgiana Gligor <g@lolaent.com>
 */
namespace CTI\ForecastBundle\Forecast;

use JMS\Serializer\Annotation as JMS;

/**
 * The response of the forecast call.
 *
 * @package CTI\ForecastBundle\Forecast
 * @author  Georgiana Gligor <g@lolaent.com>
 */
class Response
{

    /**
     * @JMS\Type("double")
     */
    protected $latitude;

    /**
     * @JMS\Type("double")
     */
    protected $longitude;

    /**
     * @JMS\Type("string")
     */
    protected $icon;

    /**
     * @JMS\Type("string")
     */
    protected $timezone;

    /**
     * @JMS\Type("integer")
     */
    protected $offset;

    /**
     * @JMS\Type("CTI\ForecastBundle\Forecast\DataPoint")
     */
    protected $currently;

    /**
     * @JMS\Type("CTI\ForecastBundle\Forecast\DataBlock")
     */
    protected $minutely;

    /**
     * @JMS\Type("CTI\ForecastBundle\Forecast\DataBlock")
     */
    protected $hourly;

    /**
     * @JMS\Type("CTI\ForecastBundle\Forecast\DataBlock")
     */
    protected $daily;

    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return mixed
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @return mixed
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @return DataPoint
     */
    public function getCurrently()
    {
        return $this->currently;
    }

    /**
     * @return DataBlock
     */
    public function getMinutely()
    {
        return $this->minutely;
    }

    /**
     * @param null|\DateTime $neededDay
     * @return DataPoint | null
     */
    public function getDaily(\DateTime $neededDay = null)
    {
        //return all records if there's no criteria specified
        if (is_null($neededDay)) {
            return $this->daily;
        }

        foreach ($this->daily->getData() as $dataPoint) {
            /** @var \CTI\ForecastBundle\Forecast\DataPoint $dataPoint  */
            $returned = \DateTime::createFromFormat( 'U', $dataPoint->getTime());
            if ($returned == $neededDay) {
                return $dataPoint;
            }
        }

        return null;
    }

    /**
     * @param null|\DateTime $neededTime
     * @return DataPoint | null
     */
    public function getHourly(\DateTime $neededTime = null)
    {
        //return all records if there's no criteria specified
        if (is_null($neededTime)) {
            return $this->hourly;
        }

        //set the minutes of the searched time to 0:
        $neededTime->setTime($neededTime->format('G'), 0);

        foreach ($this->hourly->getData() as $dataPoint) {
            /** @var \CTI\ForecastBundle\Forecast\DataPoint $dataPoint  */
            $returned = \DateTime::createFromFormat( 'U', $dataPoint->getTime());
            if ($returned == $neededTime) {
                return $dataPoint;
            }
        }

        return null;
    }

}
