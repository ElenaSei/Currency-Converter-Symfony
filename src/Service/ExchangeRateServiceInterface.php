<?php
/**
 * Created by PhpStorm.
 * User: Valentin
 * Date: 27.02.19
 * Time: 12:40
 */

namespace App\Service;

use App\Entity\ExchangeRate;

interface ExchangeRateServiceInterface
{
    public function insert(ExchangeRate $exchangeRate): bool;

}