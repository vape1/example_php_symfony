<?php
namespace Crm\AddressesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;


class FlatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	$security = $options['security'];
	
        if( $security->isGranted('ROLE_ADDRESSES_FLAT_ATTRIBUTE_READ') )
        {   
	    $builder->add('parad', null, array(
                'label' => 'p_name',
                'translation_domain' => 'address',
		'class' => 'CrmAddressesBundle:Parad',
		'property' => 'name',
                'attr' => array(
                    'class' => 'span1'
                ),
		'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('p')
		    ->innerJoin('p.house','h')
		    ->where("h.id = :houseId")
                    ->setParameter('houseId', $this->object->getHouseId())
		    ;
		},
            ))
	    
	    
	    ->add('name', null, array(
                'label' => 'f_number',
                'translation_domain' => 'address',
                'attr' => array(
		    'placeholder' => 'В форматі 1-10,14,15-20,20а, 21/3',
                    'class' => 'span5',
		    'title' => 'В форматі 1-10,14,15-20,20а, 21/3'
                )
            ))
	    
	    ->add('floor', null, array(
		'required'    => false,
                'label' => 'f_floor',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span1'
                )
            ));
	}
	
	if( $security->isGranted('ROLE_ADDRESSES_FLAT_TM_READ') )
        {  
	    $builder->add('status', 'choice', array(
		'choices'   => array(0 => 'Потенційний абонент',1 => 'Абонент', 2 => 'Не активна'),
                'label' => 'f_status',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span3'
                )
            ))
	    
	    ->add('statusDescr', 'textarea', array(
		'required'    => false,
                'label' => 'f_statusDescr',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span10'
                )
            ))
	    
	    ->add('rival', null, array(
		'required'    => false,
                'label' => 'f_rival',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span1'
                )
            ))
	    
	    ->add('flatDescr', 'textarea', array(
		'required'    => false,
                'label' => 'f_flatDescr',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span10'
                )
            ));
	}
	
         
	    if( !$security->isGranted('ROLE_ADDRESSES_FLAT_ATTRIBUTE_WRITE') and $security->isGranted('ROLE_ADDRESSES_FLAT_ATTRIBUTE_READ'))
            {
                $builder->get('parad')->setDisabled(true);
		$builder->get('floor')->setDisabled(true);
            }
	  
	    if( !$security->isGranted('ROLE_ADDRESSES_FLAT_TM_WRITE') and $security->isGranted('ROLE_ADDRESSES_FLAT_TM_READ'))
            {
                $builder->get('status')->setDisabled(true);
		$builder->get('statusDescr')->setDisabled(true);
		$builder->get('rent')->setDisabled(true);
                $builder->get('rivalInet')->setDisabled(true);
		$builder->get('rivalTv')->setDisabled(true);
		$builder->get('flatDescr')->setDisabled(true);
            }
	
	
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\AddressesBundle\Entity\Flat'
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
        return 'crm_addresses_flat_type';
    }
}