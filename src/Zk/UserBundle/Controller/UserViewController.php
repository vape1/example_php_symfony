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
use Zk\UserBundle\Form\Type\UserViewType;


class UserViewController extends AdminInterfaceController
{
    /**
     * @param string $class
     */
    public function __construct()
    {
        parent::__construct('Zk\UserBundle\Entity\UserView','uv');
    }
    
    /**
     * editAction
     */
    public function listAction( Request $request )
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $type_view = $this->container->getParameter('type_view');
        $user = $this->get('security.context')->getToken()->getUser();
        $views = $user->getUserViews();
        #echo'<pre>';print_r($results);echo'</pre>';
        
        return $this->render('ZkUserBundle:UserView:userView.html.twig',array(
            'views' => $views,
            'type_view' => $type_view,
        ));
    }
    
    public function buildListFields()
    {
        return;
    }
    
    /**
     * buildListFields
     * name,type,label,count,sort,condition_operator,options
     */
    public function buildFilterFields()
    {
        return;
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
        
        $view_obj = $this->getTotalUser()->getCurrentUserView($id);
        $container_view = $this->container->getParameter('addresses_view');
        
        if( !$view_obj )
        {
            throw new NotFoundHttpException('Page not found');
        }
        
        $form = $this->createForm( new UserViewType($view_obj), $view_obj );
        
        $views_selected = array(); // массив для уже привязанных видов (для шаблона)
        $views = array();          // массив всех видов (для шаблона)
        
        //parad, house, rack etc
        $module = $view_obj->getModule();
        
        $addresses_views = $view_obj->getConfig();
       
        //получаем массив настроек(стандартный или пользовательский)
        //$views_selected =
        //Array([list] => Array([c_nameUa] => Місто)
        //      [filter] => Array([c_nameUa] => Місто)
        //)
        foreach($addresses_views as $k=>$addresses_view) // перебор объектов привязанных видов
        {
            foreach($addresses_view as $view_type) // перебор объектов привязанных видов
            {
                $views_selected[$k][$view_type] = $this->trans($view_type,'address');
            }
        }
         
        // Получаем массив  всех доступных видов([0]=> s_name)
        $all_views =  $container_view[$module]['all'];
            
        
        foreach($all_views as $view) // перебор всех видов
        {
            // заполняем массив module_id => module_title
            $views[$view] = $this->trans($view,'address');
        }
        
        
        // удаляем из $views выбранные пользователем поля
        //$views_list и $views_filter содержат поля которые не выбрал пользователь
        $views_list = array_diff_key($views,$views_selected['list']);
        $views_filter = array_diff_key($views,$views_selected['filter']);
        
        if ($request->getMethod() == 'POST')
        {
            //массив полей
            $user_views_list['list'] = $request->request->has('user_views_list') ?
            $request->request->get('user_views_list') : array();
                
            //массив фильтров
            $user_views_filter['filter'] = $request->request->has('user_views_filter') ?
            $request->request->get('user_views_filter') : array();
               
            $user_views = $user_views_list + $user_views_filter;
            $view_obj->setConfig($user_views);
                
            if ( false === $this->isZkGranded(array('ROLE_USER_CARD_EDIT')) )
            {
                throw new AccessDeniedException();
            }
            //echo'<pre>';print_r($request);echo'</pre>';exit();
            $form->bind($request);
            
            if( $form->isValid() ) 
            {
                
                $this->EntityManager()->flush();
                
                $notice = $this->get('translator')->trans('Your changes were saved');
                $this->get('session')->getFlashBag()->add('notice', $notice);
                
                return $this->redirect( $this->generateUrl( 'zk_user_view_edit',array(
                    'id' => $view_obj->getId()
                )));
            }
        }
        
        return $this->render('ZkUserBundle:UserView:edit.html.twig', array(
            'form' => $form->createView(),
            'userView' =>  $view_obj,
            
            'views_selected_list' => $views_selected['list'],
            'views_list' => $views_list,
            'views_selected_filter' => $views_selected['filter'],
            'views_filter' => $views_filter,
        ));
    }

    /**
     * newAction
     */
    public function newAction( Request $request)
    {
        if ( false === $this->isZkGranded(array('ROLE_USER_ADD')) )
        {
            throw new AccessDeniedException();
        }
        $em = $this->get('doctrine.orm.entity_manager');
        
        $user = $this->getTotalUser();
        
        $object = new $this->class($user);
        
        $form = $this->createForm( new UserViewType($object), $object );
        
        if ($request->getMethod() == 'POST')
        {
            $default_views = $this->container->getParameter('addresses_view');
            $key = $request->request->get('zk_usertype_view');
            $key = $key['module'];
            $default_views = $default_views[$key];
            $object->setConfig($default_views);
            
            $form->bind($request);
            
            if( $form->isValid() ) 
            {
                $this->EntityManager()->persist($object);
                $this->EntityManager()->flush();
                
                $notice = $this->get('translator')->trans('Your changes were saved');
                $this->get('session')->getFlashBag()->add('notice', $notice);
                
                return $this->redirect( $this->generateUrl( 'zk_user_view_edit',array(
                    'id' => $object->getId()
                )));
            }
        }
        
        return $this->render('ZkUserBundle:UserView:edit.html.twig', array(
            'form' => $form->createView(),
            'userView' => $object,
        ));
    }
    
    /**
     * deleteAction
     */
    public function deleteAction( Request $request, $id)
    {
        $view = $this->getTotalUser()->getCurrentUserView($id);
        if( !$view )
        {
            throw new NotFoundHttpException('Page not found');
        }
      
        $em = $this->get('doctrine.orm.entity_manager');
        $em->remove($view);
        $em->flush();

        //$notice = $this->get('translator')->trans('Your changes were saved');
        $this->get('session')->getFlashBag()->add('notice', 'Налаштування видалено!');
        
        return $this->redirect( $this->generateUrl( 'zk_admin_user_edit',array(
                    'id' => $this->getTotalUser()->getId()
                )));
    }
}
