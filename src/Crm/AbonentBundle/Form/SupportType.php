<?php
namespace Crm\AbonentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Rodina\CrmBundle\Form\Type\Abonent\UserType;
use Doctrine\ORM\EntityRepository;

class SupportType extends AbstractType
{
    protected $object;
    
    public function __construct( $object )
    {
        $this->object = $object;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	$is_new = $builder->getData()->getId() ? false : true;
    
// --- resp_user FIELD ---//
        $builder->add('respUser', null, array(
	    'label' => 'call.respUser',
            'translation_domain' => 'abonent',
            'class' => 'Zk\UserBundle\Entity\User',
//            'query_builder' => function(EntityRepository $er) {
//                return $er->createQueryBuilder('u')
//	            ->where("u.abonent IS NULL")
//                ;
//            },
            'property' => 'name',
            'attr' => array(
                'title' => 'call.respUser',
		'class' => 'span3',
            )
        ));
        
// --- category FIELD ---//
        $builder->add('subcategory', null, array(
	    'required' => true,
	    'label' => 'call.subcategory',
            'translation_domain' => 'abonent',
            'attr' => array(
               'title' => 'call.subcategory',
	       'class' => 'span3',
            )
        ));
        
// --- method FIELD ---//
        $builder->add('method', null, array(
	    'required' => true,
	    'label' => 'call.method',
            'translation_domain' => 'abonent',
            'attr' => array(
                'title' => 'call.method',
		'class' => 'span3',
            )
        ));
        
// --- name FIELD ---//
        $builder->add('dateCall', null, array(
	    'label' => 'call.full_name',
            'translation_domain' => 'abonent',
            'attr' => array(
                'title' => 'abonent',
                'class' => 'span4',
            )
        ));
        
// --- contacts FIELD ---//
        $builder->add('dateOpen', null, array(
	    'label' => 'call.contacts',
            'translation_domain' => 'abonent',
            'attr' => array(
                'title' => 'abonent',
                'class' => 'span5',
            )
        ));

// --- contacts FIELD ---//
        $builder->add('dateClose', null, array(
	    'label' => 'call.contacts',
            'translation_domain' => 'abonent',
            'attr' => array(
                'title' => 'abonent',
                'class' => 'span5',
            )
        ));

// --- quest FIELD ---//
        $builder->add('quest', 'textarea', array(
	    'label' => 'call.quest',
            'translation_domain' => 'abonent',
            'attr' => array(
                'title' => 'call.quest',
	        'class' => 'span9',
	        'rows' => '3',
            )
        ));
        
// --- answer FIELD ---//
        $builder->add('answer', 'textarea', array(
	    'label' => 'call.answer',
            'translation_domain' => 'abonent',
            'required' => false,
            'attr' => array(
                'title' => 'call.answer',
	        'class' => 'span9',
	        'rows' => '3',
            )
        ));
        
// --- comment FIELD ---//
        $builder->add('comment', 'textarea', array(
	    'label' => 'call.comment',
            'translation_domain' => 'abonent',
            'required' => false,
            'attr' => array(
                'title' => 'call.respUser',
	        'class' => 'span9',
	        'rows' => '3',
            )
        ));
        
// --- log FIELD ---//
        $builder->add('log', 'textarea', array(
	    'label' => 'call.log',
            'translation_domain' => 'abonent',
            'required' => false,
            'attr' => array(
                'title' => 'call.log',
	        'class' => 'span9',
	        'rows' => '3',
            )
        ));
        
        $builder->get('log')->setDisabled(true);
        
// --- is_close FIELD ---//
        $builder->add('isClose', null, array(
	    'label' => 'call.isClose',
            'translation_domain' => 'abonent',
            'required' => false,
            'attr' => array(
                'title' => 'call.isClose',
            )
        ))
            ->add('save', 'submit', array(
		'label' => 'wiki.save',
		'translation_domain' => 'portal',
                'attr' => array(
		    'class' => 'btn btn-primary'
		),
            ));
	    
        if( !$is_new )
        {
            $builder->get('quest')->setDisabled(true);
            $builder->get('method')->setDisabled(true);
        }
        
        if( $builder->getData()->getIsClose() )
        {
            $builder->get('respUser')->setDisabled(true);
            $builder->get('subcategory')->setDisabled(true);
            $builder->get('method')->setDisabled(true);
            $builder->get('answer')->setDisabled(true);
        }
	
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\AbonentBundle\Entity\Call\Support'
        ));
    }

    public function getName()
    {
        return 'crm_calls_type';
    }
}