<?php
/**
 * Created by PhpStorm.
 * User: Valentin
 * Date: 25.02.19
 * Time: 17:45
 */

namespace AppBundle\Service;


interface ApiServiceInterface
{
    public function insertAllRates(): bool;
}