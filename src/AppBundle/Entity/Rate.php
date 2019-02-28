<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Rate
 *
 * @ORM\Table(name="rates")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RateRepository")
 */
class Rate
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     *
     */
    private $rateName;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ExchangeRate", mappedBy="rate")
     */
    private $exchangeRates;

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
        $this->exchangeRates = new ArrayCollection();
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
     * @return ArrayCollection
     */
    public function getExchangeRates()
    {
        return $this->exchangeRates;
    }

    /**
     * @param ExchangeRate $exchangeRate
     * @return Rate
     */
    public function addExchangeRate(ExchangeRate $exchangeRate)
    {
        $this->exchangeRates[] = $exchangeRate;

        return $this;
    }


}
