<?php

namespace Crm\AbonentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ApplType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dogovor_mont', null, array(
                'required'    => false,
                'label' => 'a.dogovor_mont',
                'translation_domain' => 'abonent',
                'attr' => array(
                    'class' => 'span1'
                )
            ))
            ->add('pasp_mont', null, array(
                'required'    => false,
                'label' => 'a.pasp_mont',
                'translation_domain' => 'abonent',
                'attr' => array(
                    'class' => 'span1'
                )
            ))
            ->add('net_card', null, array(
                'required'    => false,
                'label' => 'a.net_card',
                'translation_domain' => 'abonent',
                'attr' => array(
                    'class' => 'span1'
                )
            ))
            ->add('rival', null, array(
		'expanded' => true,
                'label' => 'a.rival',
                'translation_domain' => 'abonent',
                'attr' => array(
                    'class' => 'span2'
                )
            ))
            ->add('reason', null, array(
                'expanded' => true,
                'label' => 'a.reason',
                'translation_domain' => 'abonent',
                'attr' => array(
                    'class' => 'span3'
                )
            ))
            ->add('how_find', null, array(
                'expanded' => true,
                'label' => 'a.how_find',
                'translation_domain' => 'abonent',
                'attr' => array(
                    'class' => 'span1'
                )
            ))
            ->add('note', 'textarea', array(
                'required'    => false,
                'label' => 'a.appl_note',
                'translation_domain' => 'abonent',
                'attr' => array(
                    'class' => 'span5'
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
            'data_class' => 'Crm\AbonentBundle\Entity\Appl'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'crm_abonentbundle_appl';
    }
}
