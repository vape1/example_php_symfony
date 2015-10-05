<?php

namespace Crm\AbonentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CrmAbonentBundle:Default:index.html.twig', array('name' => $name));
    }
}
