<?php
namespace Crm\AddressesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

//use Rodina\CrmBundle\Form\Type\Abonent\UserType;
//use Rodina\CrmBundle\Form\Type\Abonent\AddressType;

class HouseType extends AbstractType
{
    protected $object;
    
    public function __construct( $object )
    {
        $this->object = $object;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	$security = $options['security'];
	
	if($security->isGranted('ROLE_ADDRESSES_HOUSE_ADDRESS_READ'))
	{
            $builder->add('name', null, array(
                'label' => 'h_name',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span1'
                )
            ))
	    
	    ->add('region', null, array(
                    'label' => 'r_nameUa',
                    'translation_domain' => 'address',
                    'attr' => array(
                        'class' => 'span3'
                    ) 
                ))
	    
	    ->add('houseType', null, array(
                    'label' => 'h_houseType',
                    'translation_domain' => 'address',
                    'attr' => array(
                        'class' => 'span3'
                    ) 
                ))
	     
	    ->add('subRegion', null, array(
                'label' => 'sb_nameUa',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span3'
                )
            ))
	  
	    ->add('street', null, array(
                'label' => 's_nameUa',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span3'
                )
            ));
	    
	}
	
	if($security->isGranted('ROLE_ADDRESSES_HOUSE_PAY_PORT_READ'))
	{
	    $builder->add('descr', 'textarea', array(
		'required'    => false,
                'label' => 'h_descr',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span10'
                )
            ));
	}
	
	if($security->isGranted('ROLE_ADDRESSES_HOUSE_ATTRIBUTE_READ'))
	{
	    $builder->add('payPort', null, array(
		'required'    => false,
                'label' => 'h_payPort',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span1'
                )
            ));
	}
	
	if($security->isGranted('ROLE_ADDRESSES_HOUSE_OPTIKA_READ'))
	{
	    $builder->add('optikaKan', null, array(
		'required'    => false,
                'label' => 'h_optikaKan',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span1'
                )
            ));
	    
	    $builder->add('optikaAir', null, array(
		'required'    => false,
                'label' => 'h_optikaAir',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span1'
                )
            ));
	}
	
	if( !$security->isGranted('ROLE_ADDRESSES_HOUSE_ADDRESS_WRITE') and $security->isGranted('ROLE_ADDRESSES_HOUSE_ADDRESS_READ'))
        {
            $builder->get('name')->setDisabled(true);
	    $builder->get('region')->setDisabled(true);
	    $builder->get('houseType')->setDisabled(true);
	    $builder->get('subRegion')->setDisabled(true);
	    $builder->get('street')->setDisabled(true);
        }
        
	if( !$security->isGranted('ROLE_ADDRESSES_HOUSE_PAY_PORT_WRITE') and $security->isGranted('ROLE_ADDRESSES_HOUSE_PAY_PORT_READ'))
        {
	    $builder->get('payPort')->setDisabled(true);
	}
	
	if( !$security->isGranted('ROLE_ADDRESSES_HOUSE_ATTRIBUTE_WRITE') and $security->isGranted('ROLE_ADDRESSES_HOUSE_ATTRIBUTE_READ'))
        {
	    $builder->get('descr')->setDisabled(true);
	}
	
	if( !$security->isGranted('ROLE_ADDRESSES_HOUSE_OPTIKA_WRITE') and $security->isGranted('ROLE_ADDRESSES_HOUSE_OPTIKA_READ'))
        {
	    $builder->get('optikaAir')->setDisabled(true);
	    $builder->get('optikaKan')->setDisabled(true);
	}
	
	
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\AddressesBundle\Entity\House'
        ));
	$resolver->setRequired(array(
            'security',
        ));
	
	$resolver->setAllowedTypes(array(
            'security' => 'Symfony\Component\Security\Core\SecurityContext',
        ));
    }

    public function getName()
    {
        return 'crm_addresses_house_type';
    }
}