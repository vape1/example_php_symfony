<?php

namespace Zk\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Zk\InterfaceBundle\AdminInterface\AdminInterfaceController;
use Zk\UserBundle\Entity\Role;
use Zk\UserBundle\Form\Type\RoleType;

class RoleController extends AdminInterfaceController
{
    /**
     * @param string $class
     */
    public function __construct()
    {
        parent::__construct('Zk\UserBundle\Entity\Role','r');
    }
    
    /**
     * listAction
     */
    public function listAction()
    {
        if ( false === $this->isZkGranded(array('ROLE_ROLE_LIST')) )
        {
            throw new AccessDeniedException();
        }
        
        if( $this->isReset() )
        {
            return $this->redirect( $this->generateUrl( $this->get('request')->get('_route') ) );
        }
        
        $this->buildListFields();
        $items = $this->getListFields();
        
        $this->getEm()->buildQuery();
        
        $this->getQuery()
            ->select('r')
        ;
        #echo"<pre>";print_r($this->getQuery()->getQuery()->getSql());echo"</pre>";  exit;      
        $this->buildFilterFields();
        $this->checkFilters();
        
        $pagination = $this->getPaginator(50);
        
        $filter_form = $this->getViewFiltersForm();
        
        //echo"<pre>";print_r($this->getQuery()->getQuery()->getDql());echo"</pre>";   
        //echo"<pre>";print_r($this->getQuery()->getQuery()->getParameters()->toArray());echo"</pre>";  exit; 
        
        return $this->render('ZkUserBundle:Role:list.html.twig', array(
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
            'id',
            'ID',
            'r',
            true,
            null,
            null,
            array(),
        ))
        ->addInList(array(
            'role',
            'ROLE',
            'r',
            true,
            null,
            null,
            array('link_id' => 'zk_admin_role_edit'),
        ))
        ->addInList(array(
            'name',
            'Name',
            'r',
            true,
            null,
            null,
            array()
        ))
        ->addInList(array(
            'descr',
            'Description',
            'r',
            true,
            null,
            null,
            array()
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
            'r_name',
            'text_filter',
            'Name',
            5,
            'light_text'
        ))
        ->addInFilter(array(
            'r_role',
            'text_filter',
            'ROLE',
            5,
            'light_text'
        ))
        ;
    }
    
    /**
     * editAction
     */
    public function editAction( Request $request, $id )
    {
        if ( false === $this->isZkGranded(array('ROLE_ROLE_EDIT')) )
        {
            throw new AccessDeniedException();
        }
        
        $object = $this->EntityManager()->getRepository($this->class)->find($id);
        
        $form = $this->createForm( new RoleType(), $object );
        
        #echo"<pre>";print_r($request->getSchemeAndHttpHost());echo"</pre>";
        
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if( $form->isValid() ) 
            {
                $this->EntityManager()->flush();
                
                $notice = $this->get('translator')->trans('Your changes were saved');
                $this->get('session')->getFlashBag()->add('notice', $notice);
                
                return $this->redirect( $this->generateUrl( 'zk_admin_role_edit',array(
                    'id' => $object->getId()
                )));
            }
        }
        
        return $this->render('ZkUserBundle:Role:edit.html.twig', array(
            'form' => $form->createView(),
            'role' => $object,
        ));
    }
    
    /**
     * newAction
     */
    public function newAction( Request $request )
    {
        if ( false === $this->isZkGranded(array('ROLE_ROLE_EDIT')) )
        {
            throw new AccessDeniedException();
        }
        
        $object = new Role('ROLE_NAME');
        
        $form = $this->createForm( new RoleType(), $object );
        
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if( $form->isValid() ) 
            {
                $this->EntityManager()->persist($object);
                $this->EntityManager()->flush();
                
                $notice = $this->get('translator')->trans('Your changes were saved');
                $this->get('session')->getFlashBag()->add('notice', $notice);
                
                return $this->redirect( $this->generateUrl( 'zk_admin_role_edit',array(
                    'id' => $object->getId()
                )));
            }
        }
        
        return $this->render('ZkUserBundle:Role:edit.html.twig', array(
            'form' => $form->createView(),
            'role' => $object,
        ));
    }

}
