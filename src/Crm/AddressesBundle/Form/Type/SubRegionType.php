<?php
namespace Crm\AddressesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Crm\AddressesBundle\CrmAddressesBundle;

//use Rodina\CrmBundle\Form\Type\Abonent\UserType;
//use Rodina\CrmBundle\Form\Type\Abonent\AddressType;

class SubRegionType extends AbstractType
{
    protected $object;
    
    public function __construct( $object )
    {
        $this->object = $object;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	$is_new = $builder->getData()->getId() ? false : true;
	
        $builder
            ->add('nameUa', null, array(
                'label' => 'sb_nameUa',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span4'
                )
            ))
	   
	    ->add('nameRu', null, array(
                'label' => 'sb_nameRu',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span4'
                )
            ))
	    
	    ->add('bilinkRegion', null, array(
                'label' => 'br_nameUa',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span2'
                )
            ));
	 
	    
	if( !$is_new )
        {
            $builder->get('bilinkRegion')->setDisabled(true);
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\AddressesBundle\Entity\SubRegion'
        ));
    }

    public function getName()
    {
        return 'crm_addresses_sub_region_type';
    }
}