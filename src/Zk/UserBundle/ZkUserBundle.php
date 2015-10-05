<?php

namespace Zk\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ZkUserBundle extends Bundle
{
    private static $containerInstance = null;
  
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null)
    {
        parent::setContainer($container);
        self::$containerInstance = $container;
    }
 
    public static function getContainer()
    {
        return self::$containerInstance;
    }
    
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
