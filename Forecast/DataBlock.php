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
 * A data block object represents the various weather phenomena occurring over a period of time.
 *
 * @package CTI\ForecastBundle\Forecast
 * @author  Georgiana Gligor <g@lolaent.com>
 */
class DataBlock
{

    /**
     * A human-readable text summary of this data point.
     *
     * @JMS\Type("string")
     * @var string
     */
    protected $summary;

    /**
     * A machine-readable text summary of this data block (see DataPoint, for an enumeration
     * of possible values that this property may take on).
     *
     * @JMS\Type("string")
     * @var string
     */
    protected $icon;

    /**
     * An array of DataPoint objects (see above), ordered by time,
     * which together describe the weather conditions at the requested location over time.
     *
     * @JMS\Type("array<CTI\ForecastBundle\Forecast\DataPoint>")
     * @var array
     */
    protected $data;

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

}
