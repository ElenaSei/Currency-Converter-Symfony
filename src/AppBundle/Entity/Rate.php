<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rate
 *
 * @ORM\Table(name="rate")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RateRepository")
 */
class Rate
{
    /**
     * @var int
     *
     */
    private $id;

    /**
     * @var string
     *
     */
    private $rateName;

    /**
     * @var float
     */
    private $rateExchange;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set currencyTo.
     *
     * @param $currency
     * @return Rate
     */
    public function setRateName($currency)
    {
        $this->rateName = $currency;

        return $this;
    }

    /**
     * Get currencyTo.
     *
     * @return string
     */
    public function getRateName()
    {
        return $this->rateName;
    }

    /**
     * @return float
     */
    public function getRateExchange(): float
    {
        return $this->rateExchange;
    }

    /**
     * @param float $rateExchange
     */
    public function setRateExchange(float $rateExchange): void
    {
        $this->rateExchange = $rateExchange;
    }


}
