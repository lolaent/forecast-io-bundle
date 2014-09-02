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
     */
    protected $time;

    /**
     * A human-readable text summary of this data point.
     *
     * @JMS\Type("string")
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
     */
    protected $icon;

    /**
     * The UNIX time (that is, seconds since midnight GMT on 1 Jan 1970) of the last sunrise before
     * the solar noon closest to local noon on the given day.
     *
     * @JMS\Type("integer")
     */
    protected $sunriseTime;

    /**
     * The UNIX time (that is, seconds since midnight GMT on 1 Jan 1970) of the first sunset after
     * the solar noon closest to local noon on the given day.
     *
     * @JMS\Type("integer")
     */
    protected $sunsetTime;

    /**
     * A numerical value representing the distance to the nearest storm in miles.
     *
     * @JMS\Type("integer")
     */
    protected $nearestStormDistance;

    /**
     * A numerical value representing the direction of the nearest storm in degrees,
     * with true north at 0° and progressing clockwise.
     * (If nearestStormDistance is zero, then this value will not be defined.)
     *
     * @JMS\Type("integer")
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
     */
    protected $precipIntensity;

    /**
     * the maximumum expected intensity of precipitation
     *
     * @JMS\Type("float")
     */
    protected $precipIntensityMax;

    /**
     * the UNIX time at which the maximumum expected intensity of precipitation occurs
     *
     * @JMS\Type("integer")
     */
    protected $precipIntensityMaxTime;

    /**
     * the probability of precipitation occuring at the given time
     *
     * @JMS\Type("float")
     */
    protected $precipProbability;

    /**
     * A string representing the type of precipitation occurring at the given time.
     * If defined, this property will have one of the following values: rain, snow,
     * sleet, or hail.
     * (If precipIntensity is zero, then this property will not be defined.)
     *
     * @JMS\Type("string")
     */
    protected $precipType;

    /**
     * A numerical value representing the temperature at the given time in degrees Fahrenheit
     *
     * @JMS\Type("double")
     */
    protected $temperature;

    /**
     * @JMS\Type("double")
     */
    protected $temperatureMin;

    /**
     * @JMS\Type("integer")
     */
    protected $temperatureMinTime;

    /**
     * @JMS\Type("double")
     */
    protected $temperatureMax;

    /**
     * @JMS\Type("integer")
     */
    protected $temperatureMaxTime;

    /**
     * A numerical value representing the apparent (or "feels like") temperature at the given time in degrees Fahrenheit
     *
     * @JMS\Type("double")
     */
    protected $apparentTemperature;

    /**
     * @JMS\Type("double")
     */
    protected $apparentTemperatureMin;

    /**
     * @JMS\Type("integer")
     */
    protected $apparentTemperatureMinTime;

    /**
     * @JMS\Type("double")
     */
    protected $apparentTemperatureMax;

    /**
     * @JMS\Type("integer")
     */
    protected $apparentTemperatureMaxTime;

    /**
     * A numerical value representing the dew point at the given time in degrees Fahrenheit.
     *
     * @JMS\Type("double")
     */
    protected $dewPoint;

    /**
     * A numerical value representing the wind speed in miles per hour.
     *
     * @JMS\Type("double")
     */
    protected $windSpeed;

    /**
     * A numerical value representing the direction that the wind is coming from in degrees,
     * with true north at 0° and progressing clockwise.
     * (If windSpeed is zero, then this value will not be defined.)
     *
     * @JMS\Type("double")
     */
    protected $windBearing;

    /**
     * A numerical value between 0 and 1 (inclusive) representing the percentage of sky occluded by clouds.
     * A value of 0 corresponds to clear sky, 0.4 to scattered clouds,
     * 0.75 to broken cloud cover, and 1 to completely overcast skies.
     *
     * @JMS\Type("double")
     */
    protected $cloudCover;

    /**
     * A numerical value between 0 and 1 (inclusive) representing the relative humidity.
     *
     * @JMS\Type("double")
     */
    protected $humidity;

    /**
     * A numerical value representing the sea-level air pressure in millibars.
     *
     * @JMS\Type("double")
     */
    protected $pressure;

    /**
     * A numerical value representing the average visibility in miles, capped at 10 miles.
     *
     * @JMS\Type("double")
     */
    protected $visibility;

    /**
     * A numerical value representing the columnar density of total atmospheric ozone at the given time in Dobson units.
     *
     * @JMS\Type("double")
     */
    protected $ozone;

}
