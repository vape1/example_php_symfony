<?php

namespace Zk\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Zk\InterfaceBundle\AdminInterface\AdminInterfaceController;
use Zk\UserBundle\Entity\Group;
use Zk\UserBundle\Form\Type\GroupType;

class GroupController extends AdminInterfaceController
{
    /**
     * @param string $class
     */
    public function __construct()
    {
        parent::__construct('Zk\UserBundle\Entity\Group','g');
    }
    
    /**
     * listAction
     */
    public function listAction()
    {
        if ( false === $this->isZkGranded(array('ROLE_GROUP_LIST')) )
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
            ->select('g')
        ;
        #echo"<pre>";print_r($this->getQuery()->getQuery()->getSql());echo"</pre>";  exit;      
        $this->buildFilterFields();
        $this->checkFilters();
        
        $pagination = $this->getPaginator(50);
        
        $filter_form = $this->getViewFiltersForm();
        
        return $this->render('ZkUserBundle:Group:list.html.twig', array(
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
            'g',
            true,
            null,
            null,
            array(),
        ))
        ->addInList(array(
            'name',
            'Name',
            'g',
            true,
            null,
            null,
            array('link_id' => 'zk_admin_group_edit')
        ))
        ->addInList(array(
            'descr',
            'Description',
            'g',
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
            'g_name',
            'text_filter',
            'Name',
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
        if ( false === $this->isZkGranded(array('ROLE_GROUP_EDIT')) )
        {
            throw new AccessDeniedException();
        }
        
        $object = $this->EntityManager()->getRepository($this->class)->find($id);
        
        $form = $this->createForm( new GroupType($object), $object );
        
        #echo"<pre>";print_r($request->getSchemeAndHttpHost());echo"</pre>";
        
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if( $form->isValid() ) 
            {
                $this->EntityManager()->flush();
                
                $notice = $this->get('translator')->trans('Your changes were saved');
                $this->get('session')->getFlashBag()->add('notice', $notice);
                
                return $this->redirect( $this->generateUrl( 'zk_admin_group_edit',array(
                    'id' => $object->getId()
                )));
            }
        }
        
        return $this->render('ZkUserBundle:Group:edit.html.twig', array(
            'form' => $form->createView(),
            'group' => $object,
        ));
    }
    
    /**
     * newAction
     */
    public function newAction( Request $request )
    {
        if ( false === $this->isZkGranded(array('ROLE_GROUP_EDIT')) )
        {
            throw new AccessDeniedException();
        }
        
        $object = new Group('GROUP_NAME');
        
        $form = $this->createForm( new GroupType($object), $object );
        
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if( $form->isValid() ) 
            {
                $this->EntityManager()->persist($object);
                $this->EntityManager()->flush();
                
                $notice = $this->get('translator')->trans('Your changes were saved');
                $this->get('session')->getFlashBag()->add('notice', $notice);
                
                return $this->redirect( $this->generateUrl( 'zk_admin_group_edit',array(
                    'id' => $object->getId()
                )));
            }
        }
        
        return $this->render('ZkUserBundle:Group:edit.html.twig', array(
            'form' => $form->createView(),
            'group' => $object,
        ));
    }

}
