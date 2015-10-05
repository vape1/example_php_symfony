<?php
namespace Zk\InterfaceBundle\AdminInterface\Form\Type;

use Zk\InterfaceBundle\AdminInterface\ConditionOperator;
use Zk\InterfaceBundle\AdminInterface\Form\Type\BaseFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TextFilterType extends BaseFilterType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if( $options['level'] )
        {
	    $builder->add('condition_pattern', 'choice',  array(
		'choices' => array(
                    'OR'  => 'OR',
                    'AND' => 'AND',
		),
		'attr' => array(
                    'class' => 'sf_filter_condition_pattern',
                )
            ));
        }
        
        if( $options['condition_operator'] )
        {
	    $builder->add('condition_operator', 'choice',  array(
		'choices' => ConditionOperator::get($options['condition_operator']),
		'attr' => array(
                    'class' => 'sf_filter_condition_operator',
                )
            ));
        }
	
        $builder->add('name', null, array(
	    'required' => false,
	    'attr' => array(
		'class' => 'sf_filter_text',
		'style' => 'background: #FFFFFF;',
		'data-index' => $options['data_index'],
	    )
	));
    }

    public function getName()
    {
        return 'text_filter';
    }
}