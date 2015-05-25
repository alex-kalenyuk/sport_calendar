<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class IndexController extends Controller
{
    /**
     * @Route("/{_locale}", name="homepage", requirements={"_locale" = "en|ru"}, defaults={"_locale" = "en"})
     * @Template()
     */
    public function indexAction()
    {
        return [
            'exercises' => $this->get('exercise')->getListByWeeks()
        ];
    }
}
