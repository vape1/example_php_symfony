<?php

namespace Crm\AbonentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Crm\AddressesBundle\Form\Type\FlatType;
use Crm\AbonentBundle\Form\ContactInfoPhType;


class AbonentPhType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	
	//$security = $options['security'];
        $builder
//            ->add('abonent', 'genemu_jqueryselect2_entity', array(
//                'required' => false,
//	        'empty_value' => '',
//		
//                'configs' => array(
//		    'width' => '100%',
//		    'minimumResultsForSearch' => 10,
//		    'placeholder' => 'Виберіть',
//		    'allowClear'  => true,
//	        ),
//	        'class' => 'Crm\AbonentBundle\Entity\BaseAbonent',
//                'label' => 'a_search',
//                'translation_domain' => 'abonent',
//            ))
            
            ->add('firstName', null, array(
                'label' => 'aph_abon_name',
                'translation_domain' => 'abonent',
                'attr' => array(
                    'class' => 'span3'
                )
            ))
            ->add('surname', null, array(
                'label' => 'aph_surname',
                'translation_domain' => 'abonent',
                'attr' => array(
                    'class' => 'span3'
                )
            ))
            ->add('fatherName', null, array(
                'required'    => false,
                'label' => 'aph_fatherName',
                'translation_domain' => 'abonent',
                'attr' => array(
                    'class' => 'span3'
                )
            ))
            ->add('email', null, array(
                'required'    => false,
                'label' => 'aph_email',
                'translation_domain' => 'abonent',
                'attr' => array(
                    'class' => 'span3'
                )
            ))
            ->add('phoneCont', null, array(
                'label' => 'aph_phoneCont',
                'translation_domain' => 'abonent',
                'attr' => array(
                    'class' => 'span3'
                )
            ))
	    
            ->add('contactInfo', new ContactInfoPhType())
	    ->add('flat')
	    ->add('service', new AbonentServiceType())
	    ->add('appl', new ApplType())
            //->add('tehInfo')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\AbonentBundle\Entity\AbonentPh'
        ));
	
//	$resolver->setRequired(array(
//            'security',
//        ));
//	
//	$resolver->setAllowedTypes(array(
//            'security' => 'Symfony\Component\Security\Core\SecurityContext',
//        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'crm_abonentbundle_abonentph';
    }
}
