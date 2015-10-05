<?php
namespace Zk\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Validator\Constraint\UserPassword as OldUserPassword;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Doctrine\ORM\EntityRepository;
use Zk\UserBundle\ZkUserBundle;

class UserType extends AbstractType
{
    protected $thisUser;
    protected $currentUser;
    
    public function __construct( $thisUser )
    {
	$this->thisUser = $thisUser;
	$container = ZkUserBundle::getContainer();
	$this->currentUser = $container->get('security.context')->getToken()->getUser();
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	$currentUser = $this->currentUser;
	$thisUser = $this->thisUser;
	
        $builder
            ->add('username', null, array(
                'label' => 'form.username', 'translation_domain' => 'FOSUserBundle',
                'attr' => array(
                    'class' => 'input-xlarge',
                )
            ))
            ->add('email', 'email', array(
                'label' => 'form.email', 'translation_domain' => 'FOSUserBundle',
                'attr' => array(
                    'class' => 'input-xlarge',
                )
            ))
            ->add('name', null, array(
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
                    'class' => 'span3',
                )
            ))
/*            ->add('balance', 'money', array(
                'disabled' => true,
                'label' => 'form.balance', 'translation_domain' => 'FOSUserBundle',
                'currency' => null,
                'attr' => array(
                    'class' => 'input-small',
                    'append_input'     => '$'
                ),
                'label_attr' => array( 'class' => 'required control-label' )
            ))*/
           
            //->add('enabled', null, array(
            //    'label' => 'form.enabled', 'translation_domain' => 'FOSUserBundle',
            //    'attr' => array(
            //        'class' => 'input-xlarge',
            //    )
            //))
            ->add('enabled', null, array(
                'required' => false,
                'label' => 'form.enabled', 'translation_domain' => 'FOSUserBundle',
                'attr' => array(
                    'class' => 'input-xlarge',
                )
            ))
            ->add('descr', 'textarea', array(
                'required' => false,
                'label' => 'form.descr', 'translation_domain' => 'FOSUserBundle',
                'attr' => array(
                    'class' => 'input-xlarge',
                )
            ))
            ->add('preUserRoles', 'zk_multi_select', array(
                'class' => 'ZkUserBundle:Role',
                'query_builder' => function( EntityRepository $er ) use( $currentUser, $thisUser ) {
                    $q = $er->createQueryBuilder('r');
		    if( !$currentUser->flagSuperAdmin() )
		    {
			$q = $q->where("r.id IN(:currentUserRoles)")
			->orWhere("r.id IN(:thisUserRoles)")
			->setParameter('currentUserRoles',$currentUser->getUserRoles()->count() ? $currentUser->getUserRoles()->toArray() : array(0))
			->setParameter('thisUserRoles',$thisUser->getUserRoles()->count() ? $thisUser->getUserRoles()->toArray() : array(0));
		    }
		    $q = $q->orderBy('r.name','ASC');
		    return $q;
                },
		'ZkOptionsDisabled' => !$currentUser->flagSuperAdmin() ? $this->getOptionsDisabled() : '[]',
                'required' => false,
                'label' => 'form.userRoles', 'translation_domain' => 'FOSUserBundle',
                'expanded' => false,
	        'multiple' => true,
                'ZkHeight' =>  250,
                'ZkWidth'  =>  400,
                'ZkSearch' =>  'true',
                'ZkRange'  =>  'false',
	        'ZkDescr'  =>  '{\'route\':\'zk_admin_user_role_description\'}',
                'attr' => array(
                    'class' => 'input-xlarge',
                )
            ))
            ->add('userGroups', 'zk_multi_select', array(
                'class' => 'ZkUserBundle:Group',
                'required' => false,
                'label' => 'form.userGroups', 'translation_domain' => 'FOSUserBundle',
                'expanded' => false,
	        'multiple' => true,
                'ZkHeight' =>  250,
                'ZkWidth'  =>  400,
                'ZkSearch' =>  'true',
                'ZkRange'  =>  'false',
	        'ZkDescr'  =>  '{\'route\':\'zk_admin_user_group_description\'}',
                'attr' => array(
                    'class' => 'input-xlarge',
                )
            ))
	    
        ;
	if( !$this->thisUser->getId() )
	{
            $builder->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch',
            ));
	}
	
	$builder->add('save', 'submit', array(
	    'label' => 'Save',
            'attr' => array(
		'class' => 'btn btn-primary'
	    ),
        ));
    }
    
    private function getOptionsDisabled()
    {
	$arrCurr = $arrThis = array();
	foreach( $this->currentUser->getUserRoles() as $role )
	{
	    $arrCurr[] = $role->getId();
	}
	foreach( $this->thisUser->getUserRoles() as $role )
	{
	    $arrThis[] = $role->getId();
	}
	$arrRes = array_diff( $arrThis, $arrCurr );
	return sprintf( "[%s]", implode( ',', $arrRes ) );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zk\UserBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'zk_usertype';
    }
}
