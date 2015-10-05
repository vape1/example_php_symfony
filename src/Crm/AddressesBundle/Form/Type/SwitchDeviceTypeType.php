<?php
namespace Crm\AddressesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class SwitchDeviceTypeType extends AbstractType
{
    protected $object;
    
    public function __construct( $object )
    {
        $this->object = $object;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
	    
	    ->add('idType', null, array(
                'label' => 'sdt_idType',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span2'
                )
            ))
	    
	    ->add('producer', null, array(
                'label' => 'sdt_producer',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span3'
                )
            ))
	    
	    ->add('quantPorts', null, array(
                'label' => 'sdt_quantPorts',
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
            'data_class' => 'Crm\AddressesBundle\Entity\SwitchDeviceType'
        ));
	
    }

    public function getName()
    {
        return 'crm_addresses_switch_device_type_type';
    }
}