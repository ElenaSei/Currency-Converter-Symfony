<?php

namespace AppBundle\Controller;

use AppBundle\Service\ApiServiceInterface;
use AppBundle\Service\RateServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    private $rateService;
    private $apiService;

    /**
     * DefaultController constructor.
     * @param RateServiceInterface $rateService
     * @param ApiServiceInterface $apiService
     */
    public function __construct(RateServiceInterface $rateService, ApiServiceInterface $apiService)
    {
        $this->rateService = $rateService;
        $this->apiService = $apiService;
    }

    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        //make an independent action for this and do it once per day
        //$this->apiService->insertAllRates();

        $allRates =  $this->rateService->getAllRates();

        //make an independent action for this!
        $topRates = $this->rateService->getExchangeRatesBetweenTop5();

        $result = '';
        if ($request->isMethod('POST')){

            $amount = $request->request->get('amount');
            $currFrom = $request->request->get('currFrom');
            $currTo = $request->request->get('currTo');

            $rateFrom = $this->rateService->getRate($currFrom);
            $rateTo = $this->rateService->getRate($currTo);

            $result = $this->rateService->getConvertedResult($rateFrom, $rateTo, $amount);


            $result = $result . ' ' . $rateTo->getRateName();

            return $this->render('default/index.html.twig',
                ['result' => $result,
                    'rates' => $allRates,
                    'topRates' => $topRates]);
        }

        return $this->render('default/index.html.twig',
            ['result' => $result,
                'rates' => $allRates,
                'topRates' => $topRates]);
    }

    public function topRatesAction(){

    }
}
