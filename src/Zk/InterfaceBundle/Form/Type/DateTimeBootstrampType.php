<?php

namespace Zk\InterfaceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class DateTimeBootstrampType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
	    'widget' => 'single_text',
	    'ZkWidget' => 'ZkDateTime',
	    'ZkAppend' => array(),
            'ZkDate' =>  array(
		'autoclose'          =>  'true',
		'beforeShowDay'      =>  '$.noop',
		'calendarWeeks'      =>  'true',
		'clearBtn'           =>  'true',
		'daysOfWeekDisabled' =>  '[]',
		'endDate'            =>  'Infinity',
		'forceParse'         =>  'true',
		'format'             =>  'yyyy-mm-dd',
		'keyboardNavigation' =>  'true',
		'language'           =>  'en',
		'minViewMode'        =>  0,
		'rtl'                =>  'false',
		'startDate'          =>  '-Infinity',
		'startView'          =>  0,
		'todayBtn'           =>  'true',
		'todayHighlight'     =>  'true',
		'weekStart'          =>  0
            ),
            'ZkTime'  =>  array(
                'defaultTime'    =>  'false',
                'disableFocus'   =>  'false',
                'isOpen'         =>  'false',
                'minuteStep'     =>  15,
                'modalBackdrop'  =>  'false',
                'secondStep'     =>  15,
                'showSeconds'    =>  'false',
                'showInputs'     =>  'true',
                'showMeridian'   =>  'false',
                'template'       =>  'dropdown',
                'appendWidgetTo' =>  '.bootstrap-timepicker'
            ),
            'ZkDateTime' =>  array(
	        
            ),
        ));
    }
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView( $view, $form, $options );
        
        $view->vars = array_replace($view->vars, array(
	    'ZkWidget' =>  $options['ZkWidget'],
	    'ZkAppend' =>  $options['ZkAppend'],
            'ZkDate' =>  $options['ZkDate'],
            'ZkTime'  =>  $options['ZkTime'],
            'ZkDateTime' =>  $options['ZkDateTime'],
            )
        );
    }

    
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'datetime';
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'zk_date_time_bootstramp';
    }
}