<?php
namespace Crm\AddressesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class RingType extends AbstractType
{
    protected $object;
    
    public function __construct( $object )
    {
        $this->object = $object;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
	    
	    ->add('name', null, array(
                'label' => 'sdt_idType',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span2'
                )
            ))
	    ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\AddressesBundle\Entity\Ring'
        ));
	
    }

    public function getName()
    {
        return 'crm_addresses_ring_type';
    }
}