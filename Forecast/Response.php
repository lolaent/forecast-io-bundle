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
     * @param null|string $neededDay
     * @return DataPoint | null
     */
    public function getDaily($neededDay = null)
    {
        //return all records if there's no criteria specified
        if (is_null($neededDay)) {
            return $this->daily;
        }

        $searched = new \DateTime($neededDay, new \DateTimeZone($this->getTimezone()));
        foreach ($this->daily->getData() as $dataPoint) {
            /** @var \CTI\ForecastBundle\Forecast\DataPoint $dataPoint  */
            $returned = \DateTime::createFromFormat( 'U', $dataPoint->getTime());
            $returned->setTimezone(new \DateTimeZone($this->getTimezone()));
            $returned->setTime(0, 0);
            if ($returned == $searched) {
                return $dataPoint;
            }
        }

        return null;
    }

    /**
     * @param null|string $neededTime
     * @return DataPoint | null
     */
    public function getHourly($neededTime = null)
    {
        //return all records if there's no criteria specified
        if (is_null($neededTime)) {
            return $this->hourly;
        }

        $searched = new \DateTime($neededTime, new \DateTimeZone($this->getTimezone()));
        $searched->setTime($searched->format('G'), 0);
        foreach ($this->hourly->getData() as $dataPoint) {
            /** @var \CTI\ForecastBundle\Forecast\DataPoint $dataPoint  */
            $returned = \DateTime::createFromFormat( 'U', $dataPoint->getTime());
            $returned->setTimezone(new \DateTimeZone($this->getTimezone()));
            if ($returned == $searched) {
                return $dataPoint;
            }
        }

        return null;
    }

}
