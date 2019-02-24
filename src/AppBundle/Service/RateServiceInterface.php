<?php
/**
 * Created by PhpStorm.
 * User: Valentin
 * Date: 24.02.19
 * Time: 14:48
 */

namespace AppBundle\Service;


use AppBundle\Entity\Rate;
use Doctrine\Common\Collections\ArrayCollection;

interface RateServiceInterface
{
    public function getRate(string $rate): ?Rate;

    public function getConvertedResult(string $rateFrom, string $rateTo, float $amount): ?string;

    public function getAllRates(): array ;

    public function getTop5Rates(): array ;

}