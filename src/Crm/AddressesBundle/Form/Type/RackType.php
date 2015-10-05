<?php
namespace Crm\AddressesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

//use Rodina\CrmBundle\Form\Type\Abonent\UserType;
//use Rodina\CrmBundle\Form\Type\Abonent\AddressType;

class RackType extends AbstractType
{
    protected $object;
    
    public function __construct( $object )
    {
        $this->object = $object;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	
        $builder
            ->add('placeInstall', null, array(
                'label' => 'rk_placeInstall',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span3'
                )
            ))
	    
	    ->add('keyNumber', null, array(
                    'label' => 'rk_keyNumber',
                    'translation_domain' => 'address',
                    'attr' => array(
                        'class' => 'span3'
                    ) 
            ))
	    
	    ->add('dateInstall', 'genemu_jquerydate', array(
		'required'    => false,
                'label' => 'rk_dateInstall',
                'translation_domain' => 'address',
		'widget' => 'single_text',
                'attr' => array(
                    'class' => 'span3'
                )
            ))
        ;
	
	if( !$security->isGranted('ROLE_ADDRESSES_RACK_WRITE') and $security->isGranted('ROLE_ADDRESSES_RACK_READ'))
        {
            $builder->get('placeInstall')->setDisabled(true);
	    $builder->get('keyNumber')->setDisabled(true);
	    $builder->get('dateInstall')->setDisabled(true);
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\AddressesBundle\Entity\Rack'
        ));
	
    }

    public function getName()
    {
        return 'crm_addresses_rack_type';
    }
}