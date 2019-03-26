<?php
/**
 * Created by PhpStorm.
 * User: O!
 * Date: 25.03.19
 * Time: 15:20
 */

namespace App\Dto;

use App\Service\IntegralCalculator;

/**
 * Class CoordinateDto
 * @package App\Dto
 */
class CoordinateDto
{
    /** @var float */
    protected $latitude;

    /** @var float */
    protected $longitude;

    /**
     * CoordinateDto constructor.
     * @param float $latitude
     * @param float $longitude
     */
    public function __construct(float $latitude, float $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return round($this->latitude, IntegralCalculator::MAP_ROUND_DIGITS);
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return round($this->longitude, IntegralCalculator::MAP_ROUND_DIGITS);
    }
}
