<?php

namespace Zk\InterfaceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class ZkMultiSelectType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'ZkHeight' =>  200,
            'ZkWidth'  =>  200,
            'ZkSearch' =>  true,
            'ZkRange'  =>  false,
	    'ZkDescr'  =>  false,
	    'ZkOptionsDisabled' => '[]',
        ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView( $view, $form, $options );
        
        $view->vars = array_replace($view->vars, array(
            'ZkHeight' =>  $options['ZkHeight'],
            'ZkWidth'  =>  $options['ZkWidth'],
            'ZkSearch' =>  $options['ZkSearch'],
            'ZkRange'  =>  $options['ZkRange'],
	    'ZkDescr'  =>  $options['ZkDescr'],
	    'ZkOptionsDisabled' => $options['ZkOptionsDisabled'],
            )
        );
    }

    
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'entity';
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'zk_multi_select';
    }
}