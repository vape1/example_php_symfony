<?php

namespace Crm\AddressesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Zk\InterfaceBundle\AdminInterface\AdminInterfaceController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Crm\AddressesBundle\Services\StaticFunctions;
use Crm\AddressesBundle\Form\Type\RingType;

class RingController extends AdminInterfaceController
{
    /**
     * @param string $class
     */
    public function __construct()
    {
        parent::__construct('Crm\AddressesBundle\Entity\Ring','rng');
    }
    
    public function indexAction()
    {
        if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_VIEW')) )
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
            ->select('rng')
        ;
        
        $this->buildFilterFields();
        $this->checkFilters();
        
        $pagination = $this->getPaginator(30);
        
        $filter_form = $this->getViewFiltersForm();
        
        return $this->render('CrmAddressesBundle:Ring:list.html.twig', array(
            'results'     => $pagination,
            'items'       => $items,
            'filter_form' => $filter_form,
        ));
    }
    
    /**
     * buildListFields Rack
     * name,label,alias,sort,func,filter,options,method
     */
    public function buildListFields()
    {   
        $this
        ->addInList(array(
            'name',
            $this->trans('rng_name','address'),
            'rng',
            true,
            null,
            null,
            array('link_id' => 'crm_addresses_ring_edit','style' => 'text-align:center')
           
        ));
    }
    
    /**
     * buildListFields Rack
     * name,type,label,count,sort,condition_operator,options
     */
    public function buildFilterFields()
    {
        $this->addInFilter(array(
            'rng_name',
            'text_filter',
            $this->trans('rng_name','address'),
            5,
            'light_text'
        ));
        
    }
    
    /**
     * editRingAction
     */
    public function editAction( Request $request, $id )
    {
        if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_VIEW')) )
        {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $object = $em->getRepository($this->class)->find($id);
        
        if( !$object )
        {
            throw new NotFoundHttpException('Свіч не знайдено!');
        }
        
        $form = $this->createForm(new RingType($object), $object, array(
                'action' => $this->generateUrl('crm_addresses_ring_edit',array(
                'id' => $object->getId()
            )),
              
        ));
        
        $form->handleRequest($request);
        
        if ($form->isValid())
        {
            if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_EDIT')) )
            {
                throw new AccessDeniedException();
            }
            
            $em->flush();
            
            $notice = $this->get('translator')->trans('Your changes were saved');
            $this->get('session')->getFlashBag()->add('success', $notice);
                
            return $this->redirect( $this->generateUrl( 'crm_addresses_ring_edit',array(
                'id' => $object->getId()
            )));
        }
        
        return $this->render('CrmAddressesBundle:Ring:edit.html.twig', array(
            'form' => $form->createView(),
            'ring' => $object
        ));
    }
    
    /**
     * newRingAction
     */
    public function newAction( Request $request)
    {
        if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_ADD')) )
        {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $object = new $this->class();
     
        $form = $this->createForm( new RingType($object), $object);
        
        $form->handleRequest($request);
         
            if( $form->isValid() ) 
            {
                $this->EntityManager()->persist($object);
                $this->EntityManager()->flush();
                
                $notice = $this->get('translator')->trans('Your changes were saved');
                $this->get('session')->getFlashBag()->add('success', $notice);
                
                return $this->redirect( $this->generateUrl( 'crm_addresses_ring_edit',array(
                    'id' => $object->getId()
                )));
            }
         
        return $this->render('CrmAddressesBundle:Ring:edit.html.twig', array(
            'form' => $form->createView(),
            'ring' => $object,
        ));
    }

    
    /**
     * deleteSwitchDeviceType
     */
    public function deleteAction( Request $request, $id )
    {
        if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_DELETE')) )
        {
            $error = $this->get('translator')->trans('You do not have enough privileges to carry out this action');
            $this->get('session')->getFlashBag()->add('error', $error);
        }
        else
        {
            $em = $this->getDoctrine()->getManager();
            $object  = $em->getRepository($this->class)->find($id);
            if( $object)
            {
                $log = $this->getTotalUser()->getName().' :: '
                .$object->getName().' -> delete';
                
                $em->remove( $object  );
                $em->flush();
                
                StaticFunctions::writeLog(
                    $this->get('kernel')->getRootDir().'/logs/deleteRingAction.log',
                    array($log)
                );
                $this->get('session')->getFlashBag()->add('success', 'Ring видалено');
            }
            else
            {
                throw new NotFoundHttpException('Ring не знайдено!');
            }
        }
        
        return $this->redirect( $this->generateUrl( 'crm_addresses_ring_list'));
    }
}
