<?php

namespace Crm\AbonentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AbonentServiceType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('service', null, array(
                'label' => 's.tarif',
                'translation_domain' => 'abonent',
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
            'data_class' => 'Crm\AbonentBundle\Entity\AbonentService'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'crm_abonentbundle_abonent_service';
    }
}
