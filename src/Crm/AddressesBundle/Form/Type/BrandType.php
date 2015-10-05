<?php
namespace Crm\AddressesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

//use Rodina\CrmBundle\Form\Type\Abonent\UserType;
//use Rodina\CrmBundle\Form\Type\Abonent\AddressType;

class BrandType extends AbstractType
{
    protected $object;
    
    public function __construct( $object )
    {
        $this->object = $object;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	
        $builder
            ->add('brandType', null, array(
                'label' => 'name',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span3'
                )
            ))
	    
	    ->add('dateInstall','genemu_jquerydate', array(
                'required'    => false,
                'label' => 'b_dateInstall',
                'translation_domain' => 'address',
                'widget' => 'single_text',
		'attr' => array(
                    'class' => 'span3'
                )
            ))
	    
	    ->add('installer', null, array(
		'required'    => false,
                'label' => 'b_worker',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span3'
                )
            ))
	  
	    ->add('planned', null, array(
		'required'    => false,
                'label' => 'b_planned',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span3',
		    'title' => 'Дзеркало не буде відображатись в статистиці'
                )
            ))
	    
	    ->add('descr', 'textarea', array(
		'required'    => false,
                'label' => 'b_descr',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span10'
                )
            ))
	    
	    ->add('prom_door_parad', null, array(
		'required'    => false,
                'label' => 'b_prom_door_parad',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span1'
                )
            ))
	     
	    ->add('prom_lift_door', null, array(
		'required'    => false,
                'label' => 'b_prom_lift_door',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span1'
                )
            ))
	      
	    ->add('prom_shield', null, array(
		'required'    => false,
                'label' => 'b_prom_shield',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span1'
                )
            ))
        ;
	
	
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\AddressesBundle\Entity\Brand'
        ));
    }

    public function getName()
    {
        return 'crm_addresses_brand_type';
    }
}