<?php
namespace Zk\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Zk\UserBundle\ZkUserBundle;

class UserViewType extends AbstractType
{
    protected $object;
    
    public function __construct( $object )
    {
        $this->object = $object;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	$type_view = ZkUserBundle::getContainer()->getParameter('type_view');
        $builder
            ->add('module', 'choice', array(
		'choices'   => $type_view,
                'label' => 'uv_module', 'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span2',
                )
            ))
            ->add('name', null, array(
                'label' => 'uv_name', 'translation_domain' => 'address',
                'attr' => array(
                    'class' => 'span2',
                )
            ))
          ;
	
	$builder->add('save', 'submit', array(
	    'label' => 'Save',
            'attr' => array(
		'class' => 'btn btn-primary'
	    ),
        ));
	
	if($this->object->getId())$builder->get('module')->setDisabled(true);
    }
    
    private function getOptionsDisabled()
    {
	
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zk\UserBundle\Entity\UserView'
        ));
    }

    public function getName()
    {
        return 'zk_usertype_view';
    }
}
