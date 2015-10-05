<?php
namespace Crm\AddressesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Crm\AddressesBundle\CrmAddressesBundle;

//use Rodina\CrmBundle\Form\Type\Abonent\UserType;
//use Rodina\CrmBundle\Form\Type\Abonent\AddressType;

class ServiceOrgDepType extends AbstractType
{
    protected $object;
    
    public function __construct( $object )
    {
        $this->object = $object;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	$type_street = CrmAddressesBundle::getContainer()->getParameter('type_street');
	$is_new = $builder->getData()->getId() ? false : true;
	
        $builder
            ->add('name', null, array(
                'label' => 'sod_name',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span4'
                )
            ));
	   
	    $builder->add('info', null, array(
                'label' => 'sod_info',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span5'
                )
            ));
	    
	    $builder->add('keyAddress', null, array(
                'label' => 'sod_keyAddress',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span4'
                )
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\AddressesBundle\Entity\ServiceOrgDep'
        ));
    }

    public function getName()
    {
        return 'crm_addresses_service_org_dep_type';
    }
}