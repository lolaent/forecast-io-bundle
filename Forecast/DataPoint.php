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
 * A data point object represents the various weather phenomena
 *      occurring at a specific instant of time.
 * All of these properties (except time) are optional, and will only be set
 *      if we have that type of information for that location and time.
 *
 * @package CTI\ForecastBundle\Forecast
 * @author  Georgiana Gligor <g@lolaent.com>
 */
class DataPoint
{

    /**
     * The UNIX time (that is, seconds since midnight GMT on 1 Jan 1970) at which this data point occurs.
     *
     * @JMS\Type("integer")
     * @var integer
     */
    protected $time;

    /**
     * A human-readable text summary of this data point.
     *
     * @JMS\Type("string")
     * @var string
     */
    protected $summary;

    /**
     * A machine-readable text summary of this data point, suitable for selecting an icon for display.
     * If defined, this property will have one of the following values:
     * -> clear-day,
     * -> clear-night,
     * -> rain,
     * -> snow,
     * -> sleet,
     * -> wind,
     * -> fog,
     * -> cloudy,
     * -> partly-cloudy-day, or
     * -> partly-cloudy-night.
     *
     * @JMS\Type("string")
     * @var string
     */
    protected $icon;

    /**
     * The UNIX time (that is, seconds since midnight GMT on 1 Jan 1970) of the last sunrise before
     * the solar noon closest to local noon on the given day.
     *
     * @JMS\Type("integer")
     * @var integer
     */
    protected $sunriseTime;

    /**
     * The UNIX time (that is, seconds since midnight GMT on 1 Jan 1970) of the first sunset after
     * the solar noon closest to local noon on the given day.
     *
     * @JMS\Type("integer")
     * @var integer
     */
    protected $sunsetTime;

    /**
     * A numerical value representing the distance to the nearest storm in miles.
     *
     * @JMS\Type("float")
     * @var float
     */
    protected $nearestStormDistance;

    /**
     * A numerical value representing the direction of the nearest storm in degrees,
     * with true north at 0° and progressing clockwise.
     * (If nearestStormDistance is zero, then this value will not be defined.)
     *
     * @JMS\Type("float")
     * @var float
     */
    protected $nearestStormBearing;

    /**
     * A numerical value representing the average expected intensity (in inches of liquid water per hour)
     * of precipitation occurring at the given time conditional on probability.
     *
     * A very rough guide is that a value of 0 in./hr. corresponds to no precipitation,
     * 0.002 in./hr. corresponds to very light precipitation, 0.017 in./hr. corresponds to light precipitation,
     * 0.1 in./hr. corresponds to moderate precipitation, and 0.4 in./hr. corresponds to heavy precipitation.
     *
     * @JMS\Type("float")
     * @var float
     */
    protected $precipIntensity;

    /**
     * the maximumum expected intensity of precipitation
     *
     * @JMS\Type("double")
     * @var float
     */
    protected $precipIntensityMax;

    /**
     * the UNIX time at which the maximumum expected intensity of precipitation occurs
     *
     * @JMS\Type("integer")
     * @var float
     */
    protected $precipIntensityMaxTime;

    /**
     * the probability of precipitation occuring at the given time
     *
     * @JMS\Type("double")
     * @var float
     */
    protected $precipProbability;

    /**
     * A string representing the type of precipitation occurring at the given time.
     * If defined, this property will have one of the following values: rain, snow,
     * sleet, or hail.
     * (If precipIntensity is zero, then this property will not be defined.)
     *
     * @JMS\Type("string")
     * @var string
     */
    protected $precipType;

    /**
     * A numerical value representing the temperature at the given time in degrees Fahrenheit
     *
     * @JMS\Type("double")
     * @var float
     */
    protected $temperature;

    /**
     * @JMS\Type("double")
     * @var float
     */
    protected $temperatureMin;

    /**
     * @JMS\Type("integer")
     * @var integer
     */
    protected $temperatureMinTime;

    /**
     * @JMS\Type("double")
     * @var float
     */
    protected $temperatureMax;

    /**
     * @JMS\Type("integer")
     * @var integer
     */
    protected $temperatureMaxTime;

    /**
     * A numerical value representing the apparent (or "feels like") temperature at the given time in degrees Fahrenheit
     *
     * @JMS\Type("double")
     * @var float
     */
    protected $apparentTemperature;

    /**
     * @JMS\Type("double")
     * @var float
     */
    protected $apparentTemperatureMin;

    /**
     * @JMS\Type("integer")
     * @var integer
     */
    protected $apparentTemperatureMinTime;

    /**
     * @JMS\Type("double")
     * @var float
     */
    protected $apparentTemperatureMax;

    /**
     * @JMS\Type("integer")
     * @var integer
     */
    protected $apparentTemperatureMaxTime;

    /**
     * A numerical value representing the dew point at the given time in degrees Fahrenheit.
     *
     * @JMS\Type("double")
     * @var float
     */
    protected $dewPoint;

    /**
     * A numerical value representing the wind speed in miles per hour.
     *
     * @JMS\Type("double")
     * @var float
     */
    protected $windSpeed;

    /**
     * A numerical value representing the direction that the wind is coming from in degrees,
     * with true north at 0° and progressing clockwise.
     * (If windSpeed is zero, then this value will not be defined.)
     *
     * @JMS\Type("double")
     * @var float
     */
    protected $windBearing;

    /**
     * A numerical value between 0 and 1 (inclusive) representing the percentage of sky occluded by clouds.
     * A value of 0 corresponds to clear sky, 0.4 to scattered clouds,
     * 0.75 to broken cloud cover, and 1 to completely overcast skies.
     *
     * @JMS\Type("double")
     * @var float
     */
    protected $cloudCover;

    /**
     * A numerical value between 0 and 1 (inclusive) representing the relative humidity.
     *
     * @JMS\Type("double")
     * @var float
     */
    protected $humidity;

    /**
     * A numerical value representing the sea-level air pressure in millibars.
     *
     * @JMS\Type("double")
     * @var float
     */
    protected $pressure;

    /**
     * A numerical value representing the average visibility in miles, capped at 10 miles.
     *
     * @JMS\Type("double")
     * @var float
     */
    protected $visibility;

    /**
     * A numerical value representing the columnar density of total atmospheric ozone at the given time in Dobson units.
     *
     * @JMS\Type("double")
     * @var float
     */
    protected $ozone;

    /**
     * @return float
     */
    public function getApparentTemperature()
    {
        return $this->apparentTemperature;
    }

    /**
     * @return float
     */
    public function getApparentTemperatureMax()
    {
        return $this->apparentTemperatureMax;
    }

    /**
     * @return integer
     */
    public function getApparentTemperatureMaxTime()
    {
        return $this->apparentTemperatureMaxTime;
    }

    /**
     * @return float
     */
    public function getApparentTemperatureMin()
    {
        return $this->apparentTemperatureMin;
    }

    /**
     * @return integer
     */
    public function getApparentTemperatureMinTime()
    {
        return $this->apparentTemperatureMinTime;
    }

    /**
     * @return float
     */
    public function getCloudCover()
    {
        return $this->cloudCover;
    }

    /**
     * @return float
     */
    public function getDewPoint()
    {
        return $this->dewPoint;
    }

    /**
     * @return float
     */
    public function getHumidity()
    {
        return $this->humidity;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @return float
     */
    public function getNearestStormBearing()
    {
        return $this->nearestStormBearing;
    }

    /**
     * @return float
     */
    public function getNearestStormDistance()
    {
        return $this->nearestStormDistance;
    }

    /**
     * @return float
     */
    public function getOzone()
    {
        return $this->ozone;
    }

    /**
     * @return float
     */
    public function getPrecipIntensity()
    {
        return $this->precipIntensity;
    }

    /**
     * @return float
     */
    public function getPrecipIntensityMax()
    {
        return $this->precipIntensityMax;
    }

    /**
     * @return integer
     */
    public function getPrecipIntensityMaxTime()
    {
        return $this->precipIntensityMaxTime;
    }

    /**
     * @return float
     */
    public function getPrecipProbability()
    {
        return $this->precipProbability;
    }

    /**
     * @return string
     */
    public function getPrecipType()
    {
        return $this->precipType;
    }

    /**
     * @return float
     */
    public function getPressure()
    {
        return $this->pressure;
    }

    /**
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @return integer
     */
    public function getSunriseTime()
    {
        return $this->sunriseTime;
    }

    /**
     * @return integer
     */
    public function getSunsetTime()
    {
        return $this->sunsetTime;
    }

    /**
     * @return float
     */
    public function getTemperature()
    {
        return $this->temperature;
    }

    /**
     * @return float
     */
    public function getTemperatureMax()
    {
        return $this->temperatureMax;
    }

    /**
     * @return integer
     */
    public function getTemperatureMaxTime()
    {
        return $this->temperatureMaxTime;
    }

    /**
     * @return float
     */
    public function getTemperatureMin()
    {
        return $this->temperatureMin;
    }

    /**
     * @return integer
     */
    public function getTemperatureMinTime()
    {
        return $this->temperatureMinTime;
    }

    /**
     * @return integer
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @return float
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * @return float
     */
    public function getWindBearing()
    {
        return $this->windBearing;
    }

    /**
     * @return float
     */
    public function getWindSpeed()
    {
        return $this->windSpeed;
    }

}
