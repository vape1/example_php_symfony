<?php
namespace Crm\AddressesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Crm\AddressesBundle\CrmAddressesBundle;

//use Rodina\CrmBundle\Form\Type\Abonent\UserType;
//use Rodina\CrmBundle\Form\Type\Abonent\AddressType;

class StreetType extends AbstractType
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
            ->add('nameUa', null, array(
                'label' => 's_nameUa',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span4'
                )
            ));
	   
	    $builder->add('nameRu', null, array(
                'label' => 's_nameRu',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span4'
                )
            ))
	    ->add('typeStreetRu', 'choice', array(
                'label' => 'typeStreetRu',
		'choices'   => $type_street['ru'],
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span2'
                )
            ))
	    ->add('typeStreetUa', 'choice', array(
                'label' => 'typeStreetUa',
		'choices'   => $type_street['ua'],
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span2'
                )
            ))
	    ->add('eprasysName', null, array(
                'label' => 's_eprasysName',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span2'
                )
            ))
	    ->add('city', null, array(
                'label' => 'c_nameUa',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span3'
                )
            ));
	    
	    if( !$is_new )
            {
                $builder->get('city')->setDisabled(true);
            }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\AddressesBundle\Entity\Street'
        ));
    }

    public function getName()
    {
        return 'crm_addresses_street_type';
    }
}