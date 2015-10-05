<?php
namespace Zk\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Zk\UserBundle\ZkUserBundle;

class GroupType extends AbstractType
{
    protected $thisGroup;
    protected $currentUser;
    
    public function __construct( $thisGroup )
    {
	$this->thisGroup = $thisGroup;
	$container = ZkUserBundle::getContainer();
	$this->currentUser = $container->get('security.context')->getToken()->getUser();
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	$currentUser = $this->currentUser;
	$thisGroup = $this->thisGroup;
	
        $builder
            ->add('name', null, array(
                'label' => 'Name',
                'attr' => array(
                    'class' => 'input-xlarge',
                )
            ))
            ->add('descr', null, array(
                'required' => false,
                'label' => 'Description',
                'attr' => array(
                    'class' => 'input-xxlarge',
		)
            ))
            ->add('groupRoles', 'zk_multi_select', array(
                'class' => 'ZkUserBundle:Role',
                'query_builder' => function( EntityRepository $er ) use( $currentUser, $thisGroup ) {
                    $q = $er->createQueryBuilder('r');
		    if( !$currentUser->flagSuperAdmin() )
		    {
			$q = $q->where("r.id IN(:currentUserRoles)")
			->orWhere("r.id IN(:thisGroupRoles)")
			->setParameter('currentUserRoles',$currentUser->getUserRoles()->count() ? $currentUser->getUserRoles()->toArray() : array(0))
			->setParameter('thisGroupRoles',$thisGroup->getGroupRoles()->count() ? $thisGroup->getGroupRoles()->toArray() : array(0));
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
	    ->add('save', 'submit', array(
		'label' => 'Save',
                'attr' => array(
		    'class' => 'btn btn-primary'
		),
            ))
        ;
    }
    
    private function getOptionsDisabled()
    {
	$arrCurr = $arrThis = array();
	foreach( $this->currentUser->getUserRoles() as $role )
	{
	    $arrCurr[] = $role->getId();
	}
	foreach( $this->thisGroup->getGroupRoles() as $role )
	{
	    $arrThis[] = $role->getId();
	}
	$arrRes = array_diff( $arrThis, $arrCurr );
	return sprintf( "[%s]", implode( ',', $arrRes ) );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zk\UserBundle\Entity\Group'
        ));
    }

    public function getName()
    {
        return 'zk_grouptype';
    }
}
