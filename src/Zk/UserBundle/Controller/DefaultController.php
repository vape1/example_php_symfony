<?php

namespace Zk\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller
{
    public function setLocaleAction( $locale )
    {
        $this->get('session')->set( 'zk_locale', $locale );
        $this->get('request')->setLocale( $locale );
        return new RedirectResponse(
            $this->get( 'request' )->headers->get( 'referer' )
        );
    }
    
    public function getLanguageAction()
    {
        return new Response($this->get('session')->get( 'zk_locale' ) );
    }

}
