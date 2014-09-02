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

}