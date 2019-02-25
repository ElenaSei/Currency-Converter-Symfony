<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @var ArrayCollection|Rate
     */
    private $rates;

    /**
     * Rate constructor.
     */
    public function __construct()
    {
        $this->rates = new ArrayCollection();
    }

    /**
     * @return Rate|ArrayCollection
     */
    public function getRates()
    {
        return $this->rates;
    }

    /**
     * @param Rate $rate
     * @return Rate
     */
    public function addRate(Rate $rate)
    {
        $this->rates[] = $rate;

        return $this;
    }



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
     * @return string
     */
    public function getRateExchange()
    {
        return $this->rateExchange;
    }

    /**
     * @param string $rateExchange
     */
    public function setRateExchange(string $rateExchange): void
    {
        $this->rateExchange = $rateExchange;
    }


}
