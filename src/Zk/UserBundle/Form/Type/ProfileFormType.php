<?php
namespace Zk\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Validator\Constraint\UserPassword as OldUserPassword;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class ProfileFormType extends AbstractType
{
    private $class;

    /**
     * @param string $class The User class name
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (class_exists('Symfony\Component\Security\Core\Validator\Constraints\UserPassword')) {
            $constraint = new UserPassword();
        } else {
            // Symfony 2.1 support with the old constraint class
            $constraint = new OldUserPassword();
        }

        $this->buildUserForm($builder, $options);

        //$builder->add('current_password', 'password', array(
        //    'label' => 'form.current_password',
        //    'translation_domain' => 'FOSUserBundle',
        //    'mapped' => false,
        //    'constraints' => $constraint,
        //));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'intention'  => 'profile',
        ));
    }

    public function getName()
    {
        return 'zk_user_profile';
    }

    /**
     * Builds the embedded form representing the user.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    protected function buildUserForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email', array(
                'label' => 'form.email', 'translation_domain' => 'FOSUserBundle',
                'attr' => array(
                    'class' => 'input-xlarge',
                )
            ))
            ->add('name', null, array(
                'required' => true,
                'label' => 'form.name', 'translation_domain' => 'FOSUserBundle',
                'attr' => array(
                    'class' => 'input-xlarge',
                )
            ))
            ->add('phone', null, array(
                'label' => 'form.phone', 'translation_domain' => 'FOSUserBundle',
                'attr' => array(
                    'class' => 'input-xlarge',
                )
            ))
            ->add('sex', 'choice', array(
                'required' => false,
                'choices'   => array(1 => 'form.sex.male', 2 => 'form.sex.female'),
                'empty_value' => '',
                'label' => 'form.sex.label', 'translation_domain' => 'FOSUserBundle',
                'attr' => array(
                    'class' => 'span2',
                )
            ))
            /*->add('birthday', 'genemu_jquerydate', array(
                'required'    => false,
                'label' => 'form.birthday', 'translation_domain' => 'FOSUserBundle',
                'widget' => 'single_text',
                'years' => array(1920,date('Y')-18),
                'configs' => array(
                    'changeMonth' => true,
                    'changeYear' => true,
                    'yearRange' => "c-50:c"
                ),
                'attr' => array(
                    'class' => 'input-small',
                )
            ))
            ->add('balance', 'money', array(
                'disabled' => true,
                'label' => 'form.balance', 'translation_domain' => 'FOSUserBundle',
                'currency' => null,
                'attr' => array(
                    'class' => 'input-small',
                    'append_input'     => '$'
                ),
                'label_attr' => array( 'class' => 'required control-label' )
            ))*/
        ;
        
        $builder->get('email')->setDisabled(true);
    }
}
