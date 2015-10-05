<?php
namespace Zk\InterfaceBundle\AdminInterface\Form\Type;

use Zk\InterfaceBundle\AdminInterface\ConditionOperator;
use Zk\InterfaceBundle\AdminInterface\Form\Type\BaseFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DateFilterType extends BaseFilterType
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
                    'AND' => 'AND',
                    'OR'  => 'OR',
		),
		'attr' => array(
                    'class' => 'sf_filter_condition_pattern',
                )
            ));
        }
        
        if( $options['condition_operator'] )
        {
	    $builder->add('condition_operator', 'choice',  array(
		'choices' => ConditionOperator::get('date_from'),
		'attr' => array(
                    'class' => 'sf_filter_condition_operator',
                )
            ));
        }
	
        $builder->add('name', 'genemu_jquerydate', array(
	    'required' => false,
	    'widget' => 'single_text',
	    'format' => 'y-MM-dd',
            'configs' => array(
                'changeMonth' => true,
                'changeYear' => true,
            ),
	    'attr' => array(
		'class' => 'sf_filter_text sf_filter_text_min',
		'data-index' => $options['data_index'],
	    )
	));
    }

    public function getName()
    {
        return 'date_filter';
    }
}