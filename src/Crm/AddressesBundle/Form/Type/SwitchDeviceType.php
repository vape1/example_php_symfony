<?php
namespace Crm\AddressesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

//use Rodina\CrmBundle\Form\Type\Abonent\UserType;
//use Rodina\CrmBundle\Form\Type\Abonent\AddressType;

class SwitchDeviceType extends AbstractType
{
    protected $object;
    
    public function __construct( $object )
    {
        $this->object = $object;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
	    ->add('rack', null, array(
                'label' => 'rk_name',
		'class' => 'CrmAddressesBundle:Rack',
		'property' => 'keyNumberAndParad',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span2'
                ),
		'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('rk')
	            ->innerJoin('rk.parad','p')
		    ->innerJoin('p.house','h')
		    ->where("h.id = :houseId")
                    ->setParameter('houseId', $this->object->getHouseId())
		    ;
		},
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
	    
	    ->add('switchType', null, array(
                'label' => 'sd_switchType',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span2'
                )
            ))
	    
	    ->add('installer', null, array(
		'required'    => false,
                'label' => 'sd_installer',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span2'
                )
            ))
	    
	    ->add('ringNum', null, array(
		'empty_data' => false,
                'label' => 'sd_ringNum',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span2'
                )
            ))
	    
	    ->add('onControl', null, array(
		'required'    => false,
                'label' => 'sd_onControl',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span1'
                )
            ))
	    
	    ->add('macAddress', null, array(
                'label' => 'sd_macAddress',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span4'
                )
            ))
	    
	    ->add('serialNum', null, array(
                'label' => 'sd_serialNum',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span4'
                )
            ))
	    
	    ->add('history', 'textarea', array(
		'required'    => false,
                'label' => 'sd_history',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span10'
                )
            ))
	    
	    ->add('sfp', null, array(
		'required'    => false,
                'label' => 'sd_sfp',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span2'
                )
            ));
	    
	$builder->get('history')->setDisabled(true);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\AddressesBundle\Entity\SwitchDevice'
        ));
	
    }

    public function getName()
    {
        return 'crm_addresses_switch_device_type';
    }
}