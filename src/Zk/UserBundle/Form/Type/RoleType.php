<?php
namespace Zk\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Validator\Constraint\UserPassword as OldUserPassword;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class RoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('role', null, array(
                'label' => 'ROLE',
                'attr' => array(
                    'class' => 'input-xlarge',
                )
            ))
            ->add('name', null, array(
                'label' => 'Name',
                'attr' => array(
                    'class' => 'input-xxlarge',
                )
            ))
            ->add('descr', 'textarea', array(
                'required' => false,
                'label' => 'Description',
                'attr' => array(
                    'class' => 'input-xxlarge',
		)
            ))
	    ->add('save', 'submit', array(
		'label' => 'Save',
                'attr' => array(
		    'class' => 'btn btn-primary'
		),
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zk\UserBundle\Entity\Role'
        ));
    }

    public function getName()
    {
        return 'zk_roletype';
    }
}
