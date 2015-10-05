<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Zk\UserBundle\ZkUserBundle(),
            new Zk\InterfaceBundle\ZkInterfaceBundle(),
            
            new JMS\AopBundle\JMSAopBundle(),
            new JMS\DiExtraBundle\JMSDiExtraBundle($this),
            new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
            
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new FOS\UserBundle\FOSUserBundle(),            
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            
            new Bc\Bundle\BootstrapBundle\BcBootstrapBundle(),
            
            new Genemu\Bundle\FormBundle\GenemuFormBundle(),
            
            new Stfalcon\Bundle\TinymceBundle\StfalconTinymceBundle(),
            new Crm\AddressesBundle\CrmAddressesBundle(),
            new Crm\AbonentBundle\CrmAbonentBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
