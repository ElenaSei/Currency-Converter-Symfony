<?php
/**
 * Created by PhpStorm.
 * User: Valentin
 * Date: 24.02.19
 * Time: 14:48
 */

namespace AppBundle\Service;


use AppBundle\Entity\Rate;

interface RateServiceInterface
{
    public function getRate(string $rate): ?Rate;

    public function getConvertedResult(Rate $rateFrom, Rate $rateTo, float $amount): ?string;

    public function getAllRates(): array;

    public function getTop5Rates(): array;

    public function getExchangeRatesBetweenTop5(array $top5rates): array;
}