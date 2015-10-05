<?php

namespace Zk\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zk\InterfaceBundle\AdminInterface\AdminInterfaceController;
use Zk\UserBundle\Entity\User;
use Zk\UserBundle\Form\Type\UserType;

class UserController extends AdminInterfaceController
{
    /**
     * @param string $class
     */
    public function __construct()
    {
        parent::__construct('Zk\UserBundle\Entity\User','u');
    }
    
    /**
     * listAction
     */
    public function listAction()
    {
        if ( false === $this->isZkGranded(array('ROLE_USER_LIST')) )
        {
            throw new AccessDeniedException();
        }
        
        if( $this->isReset() )
        {
            return $this->redirect( $this->generateUrl( $this->get('request')->get('_route') ) );
        }
        
        #$object = $this->get('security.context')->getToken()->getUser();
        
        $this->buildListFields();
        $items = $this->getListFields();
        
        $this->getEm()->buildQuery();
        
        $this->getQuery()
            ->select('u')
        ;
        #echo"<pre>";print_r($this->getQuery()->getQuery()->getSql());echo"</pre>";  exit;      
        $this->buildFilterFields();
        $this->checkFilters();
        
        $pagination = $this->getPaginator(30);
        
        $filter_form = $this->getViewFiltersForm();
        
        return $this->render('ZkUserBundle:User:list.html.twig', array(
            'results'     => $pagination,
            'items'       => $items,
            'filter_form' => $filter_form,
#            'addon_options' => array( 'categories' => $this->getCategories() ),
        ));
    }
    
    /**
     * buildListFields
     * name,label,alias,sort,func,filter,options,method
     */
    public function buildListFields()
    {
        $this
        ->addInList(array(
            'name',
            $this->trans('form.name','FOSUserBundle'),
            'u',
            true,
            null,
            null,
            array('link_id' => 'zk_admin_user_edit'),
        ))
        ->addInList(array(
            'email',
            $this->trans('form.email','FOSUserBundle'),
            'u',
            true,
            null,
            null,
            array(),
        ))
        ->addInList(array(
            'enabled',
            $this->trans('form.enabled','FOSUserBundle'),
            'u',
            true,
            null,
            'yes_no',
            array('class' => 'text-center')
        ))
        ->addInList(array(
            'lastLogin',
            $this->trans('form.last_login','FOSUserBundle'),
            'u',
            true,
            'dateTimeFormat',
            null,
            array('dateTimeFormat' => 'Y-m-d H:i','class' => 'text-center')
        ))
        ->addInList(array(
            'createdAt',
            $this->trans('form.created_at','FOSUserBundle'),
            'u',
            true,
            'dateTimeFormat',
            null,
            array('dateTimeFormat' => 'Y-m-d','class' => 'text-center')
        ))
        ;
    }
    
    /**
     * buildListFields
     * name,type,label,count,sort,condition_operator,options
     */
    public function buildFilterFields()
    {
        $this
        ->addInFilter(array(
            'u_name',
            'text_filter',
            $this->trans('form.name','FOSUserBundle'),
            5,
            'light_text'
        ))
        ->addInFilter(array(
            'u_email',
            'text_filter',
            $this->trans('form.email','FOSUserBundle'),
            5,
            'light_text'
        ))
        ->addInFilter(array(
            'u_createdAt',
            'date_filter',
            $this->trans('form.created_at','FOSUserBundle'),
            5
        ))
        ->addInFilter(array(
            'u_enabled',
            'boolean_filter',
            $this->trans('form.enabled','FOSUserBundle')
        ))
        ;
    }
    
    /**
     * editAction
     */
    public function editAction( Request $request, $id )
    {
        if ( false === $this->isZkGranded(array('ROLE_USER_CARD_VIEW','ROLE_USER_CARD_EDIT')) )
        {
            throw new AccessDeniedException();
        }
        
        $object = $this->EntityManager()->getRepository($this->class)->find($id);
        
        if( !$object )
        {
            throw new NotFoundHttpException('Page not found');
        }
        
        $form = $this->createForm( new UserType($object), $object );
        
        
        if ($request->getMethod() == 'POST')
        {
            if ( false === $this->isZkGranded(array('ROLE_USER_CARD_EDIT')) )
            {
                throw new AccessDeniedException();
            }
            
            $form->bind($request);
            
            if( $form->isValid() ) 
            {
                $this->EntityManager()->flush();
                
                //$userManager = $this->container->get('fos_user.user_manager');
                //$userManager->refreshUser($object);
                
                $notice = $this->get('translator')->trans('Your changes were saved');
                $this->get('session')->getFlashBag()->add('notice', $notice);
                
                return $this->redirect( $this->generateUrl( 'zk_admin_user_edit',array(
                    'id' => $object->getId()
                )));
            }
        }
        
        return $this->render('ZkUserBundle:User:edit.html.twig', array(
            'form' => $form->createView(),
            'user' => $object,
        ));
    }

    /**
     * newAction
     */
    public function newAction( Request $request )
    {
        if ( false === $this->isZkGranded(array('ROLE_USER_ADD')) )
        {
            throw new AccessDeniedException();
        }
        
        $object = new $this->class;
        
        $form = $this->createForm( new UserType($object), $object );
        
        #echo"<pre>";print_r($request->getSchemeAndHttpHost());echo"</pre>";
        
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if( $form->isValid() ) 
            {
                $this->EntityManager()->persist($object);
                $this->EntityManager()->flush();
                
                $notice = $this->get('translator')->trans('Your changes were saved');
                $this->get('session')->getFlashBag()->add('notice', $notice);
                
                return $this->redirect( $this->generateUrl( 'zk_admin_user_edit',array(
                    'id' => $object->getId()
                )));
            }
        }
        
        return $this->render('ZkUserBundle:User:edit.html.twig', array(
            'form' => $form->createView(),
            'user' => $object,
        ));
    }
    
    /**
     * gorupDescriptionAction
     */
    public function gorupDescriptionAction( Request $request, $id )
    {
        $object = $this->EntityManager()->getRepository('ZkUserBundle:Group')->find($id);
        
        $description = $object ? $object->getFullDescr() : null;
        
        return new Response($description);
    }

    /**
     * roleDescriptionAction
     */
    public function roleDescriptionAction( Request $request, $id )
    {
        $object = $this->EntityManager()->getRepository('ZkUserBundle:Role')->find($id);
        
        $description = $object ? $object->getDescr() : null;
        
        return new Response($description);
    }


}
