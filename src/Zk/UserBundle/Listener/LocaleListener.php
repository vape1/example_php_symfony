<?php

namespace Zk\UserBundle\Listener;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class LocaleListener
{
    const DEFAULT_LOCALE = 'en';
    
    protected $container;
    protected $availableLocales;

    public function __construct( Container $container, $availableLocales )
    {
        $this->container = $container;
        $this->availableLocales = $availableLocales;
    }

    public function onKernelRequest( GetResponseEvent $event )
    {
        $request = $this->container->get('request');
        $session = $this->container->get('session');
        
        $locale = !in_array($request->getLocale(),$this->availableLocales)
        ? $request->getLocale() : $this->container->getParameter('locale');

        if( !$session->has('zk_locale') )
        {
            $session->set( 'zk_locale', $locale );
        }
        
        $request->setLocale( $session->get('zk_locale') );
    }
}