<?php

namespace Crm\AbonentBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
#use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Zk\InterfaceBundle\AdminInterface\AdminInterfaceController;

use Crm\AbonentBundle\Form\SupportType;
use Crm\AbonentBundle\Entity\Call\Support;

class CallsController extends AdminInterfaceController
{
    /**
     * @param string $class
     */
    public function __construct()
    {
        parent::__construct('Crm\AbonentBundle\Entity\Call\Support','s');
    }
    
    /**
     * listAction
     */
    public function listAction()
    {
        //if ( false === $this->isZkGranded(array('ROLE_ABONENT_LIST')) )
        //{
        //    throw new AccessDeniedException();
        //}
        
        if( $this->isReset() )
        {
            return $this->redirect( $this->generateUrl( $this->get('request')->get('_route') ) );
        }
        
        $this->buildListFields();
        $items = $this->getListFields();
         
        $this->getEm()->buildQuery();
       
        $this->getQuery()
            ->select('s','sub,cat','m','a','u','u1')
            ->leftJoin('s.subcategory','sub')
            ->leftJoin('sub.category','cat')
            ->leftJoin('s.method','m')
            ->leftJoin('s.abonent','a')
            ->leftJoin('s.respUser','u')
            ->leftJoin('a.user','u1')
            ->orderBy('s.isClose')
            ->addOrderBy('s.dateCall','desc')
        ;
        
        $this->buildFilterFields();
        $this->checkFilters();
        
        $pagination = $this->getPaginator(30);
        
        $filter_form = $this->getViewFiltersForm();
        
        return $this->render('CrmAbonentBundle:Calls:list.html.twig', array(
            'results'     => $pagination,
            'items'       => $items,
            'filter_form' => $filter_form,
            //'addon_options' => array( 'categories' => $this->getCategories() ),
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
            'email',
            $this->trans('call.email','abonent'),
            'u1',
            true,
            null,
            null,
            array('style' => 'text-align:center'),
            'email',
        ))
        ->addInList(array(
            'name',
            $this->trans('call.full_name','abonent'),
            'a',
            true,
            null,
            null,
            array(),
        ))
        ->addInList(array(
            'name',
            $this->trans('call.category','abonent'),
            'sub',
            true,
            null,
            null,
            array(),
            'subcategory'
        ))
        ->addInList(array(
            'name',
            $this->trans('call.method','abonent'),
            'm',
            true,
            null,
            null,
            array('style' => 'text-align:center'),
            'method'
        ))
        ->addInList(array(
            'name',
            $this->trans('call.respUser','abonent'),
            'u',
            true,
            null,
            null,
            array('style' => 'text-align:center'),
            'respUserName'
        ))
        ->addInList(array(
            'dateCall',
            $this->trans('call.date_call','abonent'),
            's',
            true,
            'dateTimeFormat',
            null,
            array('dateTimeFormat' => 'Y-m-d H:i','class' => 'zeka_center')
        ))
        ->addInList(array(
            'dateOpen',
            $this->trans('call.date_open','abonent'),
            's',
            true,
            'dateTimeFormat',
            null,
            array('dateTimeFormat' => 'Y-m-d H:i','class' => 'zeka_center')
        ))
        ->addInList(array(
            'dateClose',
            $this->trans('call.date_close','abonent'),
            's',
            true,
            'dateTimeFormat',
            null,
            array('dateTimeFormat' => 'Y-m-d H:i','class' => 'zeka_center')
        ))
        ->addInList(array(
            'isClose',
            $this->trans('call.is_close','abonent'),
            's',
            true,
            null,
            'yes_no',
            array('class' => 'zeka_center')
        ))
        ->addInList(array(
            'edit',
            $this->trans('call.edit','abonent'),
            null,
            false,
            null,
            null,
            array('link_id' => 'rodina_crm_calls_edit','class' => 'zeka_center')
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
        ->addInFilter(array('a_email','text_filter','Email',5,'full_text'))
        ->addInFilter(array('a_name','text_filter',$this->trans('call.full_name','abonent'),5,'full_text'))
        ->addInFilter(array('u_name','text_filter',$this->trans('call.responce','abonent'),5,'full_text'))
        ->addInFilter(array('s_isClose','boolean_filter',$this->trans('call.is_close','abonent')))
        ->addInFilter(array('sub_name','entity_filter',$this->trans('call.category','abonent'),5,'smal_int',
                            array(
                                  'entity_class' => 'Crm\AbonentBundle\Entity\Call\CallSubCategory',
                                  'property' => 'name',
                            )))
        ->addInFilter(array('m_name','entity_filter',$this->trans('call.method','abonent'),5,'smal_int',
                            array(
                                  'entity_class' => 'Crm\AbonentBundle\Entity\Call\CallMethod',
                                  'property' => 'name',
                            )))
        ;
    }
    
    /**
     * Edit Call Action
     */
    public function editAction( Request $request, $id )
    {
        $em = $this->getDoctrine()->getManager();
        
        $call = $em->getRepository($this->class)->find($id);
        
        if (!$call)
        {
            throw $this->createNotFoundException('Object not found');
        }
        
        $user = $this->get('security.context')->getToken()->getUser();
        
        if( !$call->getOpenUser() )
        {
            $call->setLog(sprintf("%s -- Автоматическое назначение на %s",date('Y-m-d H:i'),$user->getName()));
            $call->setOpenUser($user);
            $call->setRespUser($user);
            $call->setDateOpen( new \DateTime() );
            $em->flush();
        }
        
        $call->initOldValues();
        
        $send_email =  ( !$call->getSupport() and in_array( $call->getMethod()->getName(), array('Сайт','Email') ) );
        
        $form = $this->createForm(new SupportType($call), $call, array(
            'action' => $this->generateUrl('abonent_calls_edit',array(
                'id' => $call->getId(),
            )),
        ));
        
        $form->handleRequest($request);
        
        if ($form->isValid())
        {
            $call->setLog($call->getLog().' ');
            $add_notice = '';
                if( $request->request->has('go_send_email') )
                {
                    $email = trim( $request->request->get('text_send_email') );
                    
                    $body = trim($call->getAnswer());
                    
                    if( !$body ) $add_notice = ' НЕ ЗАПОЛНЕН ОТВЕТ!!!';
                    
                    else
                    {
                        if( filter_var($email, FILTER_VALIDATE_EMAIL) )
                        {
                            $mailer = $this->container->get('mailer');
                            $subject = 'Bilink: Ответ на обрашение';
                
                            //$message = \Swift_Message::newInstance()
                            //    ->setSubject( $subject )
                            //    ->setFrom( array( $this->container->getParameter('mailer_user') => 'Bilink' ) )
                            //    ->setTo( $email )
                            //    //->setContentType( "text/html" )
                            //    ->setBody( $body )
                            //;
                            $mailer->send( $message );
                            $add_notice = ' Отправлен ответ на email '.$email;
                            
                            $call->setSupport(true);
                        }
                        else
                        {
                            $add_notice = ' Не валидный email '.$email;
                        }
                    }
                }
                
            $em->flush();
                
            $notice = $this->get('translator')->trans('Your changes were saved');
             
            $this->get('session')->getFlashBag()->add('notice', $notice.$add_notice);
             
            return $this->redirect( $this->generateUrl( 'abonent_calls_edit',array(
                'id' => $call->getId()
            )));
        }
        
        return $this->render('CrmAbonentBundle:Call:edit.html.twig', array(
            'form' => $form->createView(),
            'call' => $call,
            'send_email' => $send_email
        ));
    }

    
    public function abonentCallsAction( Request $request, $abonent_id )
    {
        $em = $this->get('doctrine.orm.entity_manager');
        
        $abonent = $em->getRepository('Crm\AbonentBundle\Entity\BaseAbonent')->find( $abonent_id );
       
        if( !$abonent )
        {
            throw new \Exception("Abonent not found");
        }
        
        if( $abonent )
        {
            $results = $abonent->getCalls();
        }
        
        #echo'<pre>';print_r($results);echo'</pre>';
        
        return $this->render('CrmAbonentBundle:BaseAbonent:calls.html.twig',array(
            'calls' => $results,
            'abonent_id'   => $abonent_id,
        ));
    }
    
    /**
     * calls
     *
     */
    public function newAction( Request $request, $abonent_id )
    {
        //if ( false === $this->isZkGranded(array('ROLE_CALL_VIEW')) )
        //{
        //  throw new AccessDeniedException();
        //}
        
        $em = $this->getDoctrine()->getManager();
        $user = $this->getTotalUser();
        
        $entity = new Support();
        
        $abonent = $em->getRepository('CrmAbonentBundle:BaseAbonent')
                                                ->find( $abonent_id );
                                                
        if( $abonent ) $entity->setAbonent( $abonent );
        
        
        $form = $this->createCreateForm($entity, $abonent_id);
        
        $form->handleRequest($request);  
       
        if ($form->isValid())
        {
                $entity->setLog(sprintf("%s -- Автоматическое назначение на %s",date('Y-m-d H:i'),$user->getName()));
                $entity->setOpenUser($user);
                $entity->setRespUser($user);
                $entity->setDateOpen( new \DateTime() );
                
                $em->persist($entity);
                $em->flush();
                
                $notice = $this->get('translator')->trans('Your changes were saved');
             
                $this->get('session')->getFlashBag()->add('success', $notice);
              
                return $this->redirect(
                    $this->generateUrl( 'abonent_calls_edit', array( 'id' => $entity->getId() ) )
                );
        }
        
     
        return $this->render('CrmAbonentBundle:Call:edit.html.twig',array(
            'form' => $form->createView(),
            'call' => $entity,
            'abonent_id' => $abonent_id,
        ));
    }
    
    /**
     * Creates a form to create a AbonentPh entity.
     *
     * @param AbonentPh $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Support $entity, $abonent_id)
    {
        $form = $this->createForm(new SupportType($entity), $entity, array(
            'action' => $this->generateUrl('abonent_calls_new',array('abonent_id' => $abonent_id)),
            'method' => 'POST',
        ));
      
        $form->add('submit', 'submit', array('label' => 'Create'));
       
        return $form;
    }
    
}
