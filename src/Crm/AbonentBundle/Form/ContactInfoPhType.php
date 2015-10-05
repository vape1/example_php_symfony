<?php

namespace Crm\AbonentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactInfoPhType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('phoneMob', null, array(
                'required'    => false,
                'label' => 'aph_phoneMob',
                'translation_domain' => 'abonent',
                'attr' => array(
                    'class' => 'span3'
                )
            ))
            ->add('phoneDom', null, array(
                'required'    => false,
                'label' => 'aph_phoneDom',
                'translation_domain' => 'abonent',
                'attr' => array(
                    'class' => 'span3'
                )
            ))
            ->add('notifyPhone', null, array(
                'required'    => false,
                'label' => 'aph_notifyPhone',
                'translation_domain' => 'abonent',
                'attr' => array(
                    'class' => 'span1'
                )
            ))
            ->add('os', 'choice', array(
                'label' => 'aph_os',
                'translation_domain' => 'abonent',
                'choices' => array(0=>'Windows',1=>'Linux'),//вынести в сущность
                'attr' => array(
                    'class' => 'span2'
                )
            ))
            ->add('flagDog', null, array(
                'required'    => false,
                'label' => 'aph_flagDog',
                'translation_domain' => 'abonent',
                'attr' => array(
                    'class' => 'span1'
                )
            ))
            ->add('flagPasp', null, array(
                'required'    => false,
                'label' => 'aph_flagPasp',
                'translation_domain' => 'abonent',
                'attr' => array(
                    'class' => 'span1'
                )
            ))
            //не работает minDate
            ->add('birthDay', 'genemu_jquerydate', array(
                'required'    => false,
                'label' => 'aph_birthDay',
                'translation_domain' => 'abonent',
                'widget' => 'single_text',
                'configs' => array(
                    'changeMonth' => true,
                    'changeYear' => true,
                ),
                'attr' => array(
                    'class' => 'span3'
                )
            ))
            ->add('profile', 'textarea', array(
                'required'    => false,
                'label' => 'aph_profile',
                'translation_domain' => 'abonent',
                'attr' => array(
                    'class' => 'span5'
                )
            ))
	    ->add('paspSer', null, array(
		'required'    => false,
                'label' => 'aph_paspSer',
                'translation_domain' => 'abonent',
                'attr' => array(
                    'class' => 'span1'
                )
            ))
	    ->add('paspNum', null, array(
		'required'    => false,
                'label' => 'aph_paspNum',
                'translation_domain' => 'abonent',
                'attr' => array(
                    'class' => 'span1'
                )
            ))
	    ->add('paspWhom', 'textarea', array(
		'required'    => false,
                'attr' => array(
                    'class' => 'span3'
                )
            ))
	    ->add('paspWhomChoice', 'choice', array(
		"mapped" => false,
		'required'    => false,
                'label' => 'aph_paspWhom',
                'translation_domain' => 'abonent',
		'choices' => array(0=>'Windows',1=>'Linux'),
                'attr' => array(
                    'class' => 'span3'
                )
            ))
	    
	    ->add('paspIpn', null, array(
		'required'    => false,
                'label' => 'aph_paspIpn',
                'translation_domain' => 'abonent',
                'attr' => array(
                    'class' => 'span2'
                )
            ))
	    
	    ->add('rent', null, array(
		'required'    => false,
                'label' => 'f_rent',
                'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span3'
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\AbonentBundle\Entity\ContactInfoPh'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'crm_abonentbundle_contactinfoph';
    }
}
