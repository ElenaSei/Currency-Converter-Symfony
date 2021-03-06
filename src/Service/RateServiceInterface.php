<?php
/**
 * Created by PhpStorm.
 * User: Valentin
 * Date: 24.02.19
 * Time: 14:48
 */

namespace App\Service;


use App\Entity\Rate;

interface RateServiceInterface
{
    public function getRate(string $rate): ?Rate;

    public function getConvertedResult(Rate $rateFrom, Rate $rateTo, float $amount): ?string;

    public function getAllRates(): array;

    public function getTopRates(): array;

    public function getExchangeRatesBetweenTop5(): array;

    public function insert(Rate $rate): bool;

    public function findOneByName(string $name);
}