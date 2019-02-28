<?php
/**
 * Created by PhpStorm.
 * User: Valentin
 * Date: 27.02.19
 * Time: 12:40
 */

namespace AppBundle\Service;


use AppBundle\Entity\ExchangeRate;

interface ExchangeRateServiceInterface
{
    public function insert(ExchangeRate $exchangeRate): bool;

}