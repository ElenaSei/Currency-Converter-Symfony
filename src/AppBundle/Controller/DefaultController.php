<?php

namespace AppBundle\Controller;

use AppBundle\Service\RateServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    private $rateService;

    /**
     * DefaultController constructor.
     * @param RateServiceInterface $rateService
     */
    public function __construct(RateServiceInterface $rateService)
    {
        $this->rateService = $rateService;
    }

    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $allRates =  $this->rateService->getAllRates();

        $result = '';
        if ($request->isMethod('POST')){

            $amount = $request->request->get('amount');
            $currFrom = $request->request->get('currFrom');
            $currTo = $request->request->get('currTo');

            $rateFrom = $this->rateService->getRate($currFrom);
            $rateTo = $this->rateService->getRate($currTo);

            $result = $this->rateService->getConvertedResult($rateFrom, $rateTo, $amount);

            return $this->render('default/index.html.twig',
                ['result' => $result,
                    'rates' => $allRates]);
        }

        return $this->render('default/index.html.twig', ['result' => $result, 'rates' => $allRates]);
    }

    public function topRatesAction(){
        $top5Rates = $this->rateService->getTop5Rates();
        $this->rateService->getExchangeRatesBetweenTop5($top5Rates);
    }
}
