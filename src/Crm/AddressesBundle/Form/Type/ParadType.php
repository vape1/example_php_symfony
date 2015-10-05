<?php
namespace Crm\AddressesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;


class ParadType extends AbstractType
{
    protected $object;
    
    public function __construct( $object )
    {
        $this->object = $object;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	$security = $options['security'];
	
        if( $security->isGranted('ROLE_ADDRESSES_PARAD_ATTRIBUTE_READ') )
        {   
	    $builder->add('name', null, array(
                'label' => 'p_name',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span1'
                )
            ))
	    
	    ->add('floor', null, array(
		'required'    => false,
                'label' => 'p_floor',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span1'
                )
            ))
	    
	    ->add('liftQuan', 'choice', array(
		'required'    => false,
		'choices'   => array(0 => '0',1 => '1', 2 => '2', 3 => '3', 4 => '4'),
                'label' => 'p_liftQuan',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span1'
                )
            ));
	}
	if( $security->isGranted('ROLE_ADDRESSES_PARAD_ACCESS_READ') )
        {
	    $builder->add('serviceOrgDep', 'genemu_jqueryselect2_entity', array(
                'required' => false,
	        'empty_value' => '',
		
                'configs' => array(
		    'width' => '100%',
		    'minimumResultsForSearch' => 10,
		    'placeholder' => 'Виберіть',
		    'allowClear'  => true,
	        ),
	        'class' => 'Crm\AddressesBundle\Entity\ServiceOrgDep',
                'label' => 'p_serviceOrg',
                'translation_domain' => 'address',
                ))
	     
	    ->add('commentAccessParad','textarea', array(
		'required'    => false,
                'label' => 'p_commentAccessParad',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span10'
                )
            ))
	    
	    ->add('accessParad', null, array(
		'required'    => false,
                'label' => 'p_accessParad',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span3'
                )
            ));
	}
	if( $security->isGranted('ROLE_ADDRESSES_PARAD_CONNECT_READ') )
        {
	    $builder->add('ableConn', null, array(
		'required'    => false,
                'label' => 'p_ableConn',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span3'
                )
            ))
	    
	    ->add('faza2', null, array(
		'required'    => false,
                'label' => 'p_faza2',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span3'
                )
            ))
	  
	    ->add('faza', 'choice', array(
                'label' => 'p_faza',
		'choices'   => array(0 => '0', 15 => '15', 1 => '1', 2 => '2', 3 => '3'),
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span1'
                )
            ))
	    
	    ->add('dateConn', 'genemu_jquerydate', array(
                'required'    => false,
                'label' => 'p_planDateConn',
                'translation_domain' => 'address',
                'widget' => 'single_text',
		'attr' => array(
                    'class' => 'span3'
                )
            ))
	    
	    ->add('bilinkStoyak', null, array(
		'required'    => false,
                'label' => 'p_bilinkStoyak',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span1'
                )
            ))
	    
	    ->add('semafor', 'choice', array(
                'label' => 'p_semafor',
		'choices'   => array(1 => '1', 2 => '2', 3 => '3'),
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span1'
                )
            ))
	 
	    ->add('conditionParad', 'textarea', array(
		'required'    => false,
                'label' => 'p_conditionParad',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span10'
                )
            ))
	    ;
	}
         
	    if( !$security->isGranted('ROLE_ADDRESSES_PARAD_ATTRIBUTE_WRITE') and $security->isGranted('ROLE_ADDRESSES_PARAD_ATTRIBUTE_READ'))
            {
                $builder->get('name')->setDisabled(true);
		$builder->get('floor')->setDisabled(true);
		$builder->get('liftQuan')->setDisabled(true);
            }
	  
	    if( !$security->isGranted('ROLE_ADDRESSES_PARAD_ACCESS_WRITE') and $security->isGranted('ROLE_ADDRESSES_PARAD_ACCESS_READ'))
            {
                $builder->get('serviceOrgDep')->setDisabled(true);
		$builder->get('commentAccessParad')->setDisabled(true);
		$builder->get('accessParad')->setDisabled(true);
            }
	    if( !$security->isGranted('ROLE_ADDRESSES_PARAD_CONNECT_WRITE') and $security->isGranted('ROLE_ADDRESSES_PARAD_CONNECT_READ'))
            {
                $builder->get('ableConn')->setDisabled(true);
		$builder->get('faza2')->setDisabled(true);
		$builder->get('faza')->setDisabled(true);
		$builder->get('dateConn')->setDisabled(true);
                $builder->get('bilinkStoyak')->setDisabled(true);
		$builder->get('semafor')->setDisabled(true);
		$builder->get('conditionParad')->setDisabled(true);
            }
	
	
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\AddressesBundle\Entity\Parad'
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
        return 'crm_addresses_parad_type';
    }
}