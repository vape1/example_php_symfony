<?php

namespace Crm\AddressesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Zk\InterfaceBundle\AdminInterface\AdminInterfaceController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Crm\AddressesBundle\Services\StaticFunctions;

use Crm\AddressesBundle\Form\Type\StreetType;

class StreetController extends AdminInterfaceController
{
    /**
     * @param string $class
     */
    public function __construct()
    {
        parent::__construct('Crm\AddressesBundle\Entity\Street','s');
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
            ->select('s,c')
            ->leftJoin('s.city','c')
        ;
        
        $this->buildFilterFields();
        $this->checkFilters();
        
        $pagination = $this->getPaginator(30);
        
        $filter_form = $this->getViewFiltersForm();
        
        return $this->render('CrmAddressesBundle:Street:list.html.twig', array(
            'results'     => $pagination,
            'items'       => $items,
            'filter_form' => $filter_form,
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
            'nameUa',
            $this->trans('c_nameUa','address'),
            'c',
            true,
            null,
            null,
            array('style' => 'text-align:center'),
            'getCityName'
        ));
        
      
        $this
        ->addInList(array(
            'nameRu',
            $this->trans('s_nameRu','address'),
            's',
            true,
            null,
            null,
            array('link_id' => 'crm_addresses_street_edit','style' => 'text-align:center'),
            'getStreetNameRu'
        ));
        
       
        $this->addInList(array(
            'nameUa',
            $this->trans('s_nameUa','address'),
            's',
            true,
            null,
            null,
            array('link_id' => 'crm_addresses_street_edit','style' => 'min-width:200px','parent_id' => 'getStreetId'),
            'getStreetNameUa'
        ));
    }
    
    /**
     * buildListFields
     * name,type,label,count,sort,condition_operator,options
     */
    public function buildFilterFields()
    {
    
        $this->addInFilter(array(
            'c_nameUa',
            'text_filter',
            $this->trans('c_nameUa','address'),
            5,
            'light_text'
        ));
       
        $this->addInFilter(array(
            's_nameUa',
            'text_filter',
            $this->trans('s_nameUa','address'),
            5,
            'light_text'
        ));
       
        $this->addInFilter(array(
            's_nameRu',
            'text_filter',
            $this->trans('s_nameRu','address'),
            5,
            'light_text'
        ));
    }
    
    /**
     * editAction
     */
    public function editAction( Request $request, $id )
    {
        if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_VIEW')) )
        {
            throw new AccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();
        
        $object = $em->getRepository($this->class)->find($id);
        if( !$object)
        {
            throw new NotFoundHttpException('Вулицю не знайдено!');
        }
        
        $form = $this->createForm(new StreetType($object), $object, array(
                'action' => $this->generateUrl('crm_addresses_street_edit',array(
                    'id' => $object->getId()
                )),
        ));
        
        $form->handleRequest($request);
        
        if ($form->isValid())
        {
            if ( false === $this->isZkGranded(array('ROLE_STREET_EDIT')) )
            {
                throw new AccessDeniedException();
            }
            
            $em->flush();
            
            $notice = $this->get('translator')->trans('Your changes were saved');
            $this->get('session')->getFlashBag()->add('success', $notice);
                
            return $this->redirect( $this->generateUrl( 'crm_addresses_street_edit',array(
                'id' => $object->getId()
            )));
        }
        
        return $this->render('CrmAddressesBundle:Street:edit.html.twig', array(
            'form' => $form->createView(),
            'id' => $object->getId()
        ));
    }
    
    /**
     * newAction
     */
    public function newAction( Request $request, $id)
    {
        if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_ADD')) )
        {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $object = new $this->class();
        
        $form = $this->createForm( new StreetType($object), $object);
        
        $form->handleRequest($request);
            
            if( $form->isValid() ) 
            {
                $this->EntityManager()->persist($object);
                $this->EntityManager()->flush();
                
                $notice = $this->get('translator')->trans('Your changes were saved');
                $this->get('session')->getFlashBag()->add('success', $notice);
                
                return $this->redirect( $this->generateUrl( 'crm_addresses_street_edit',array(
                    'id' => $object->getId()
                )));
            }
         
        return $this->render('CrmAddressesBundle:Street:edit.html.twig', array(
            'form' => $form->createView(),
            'street' => $object,
        ));
    }

    
     /**
     * deleteAbonement
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
            if($object->hasChildren())
            {
                $text = $this->get('translator')->trans('has.children');
                throw new NotFoundHttpException($text);
            }
            if( $object )
            {
                $log = $this->getTotalUser()->getName().' :: '
                .$object ->getNameUa().' '.$object ->getEprasysName().' -> delete';
                $em->remove( $object );
                $em->flush();
                StaticFunctions::writeLog(
                    $this->get('kernel')->getRootDir().'/logs/deleteStreetAction.log',
                    array($log)
                );
                $this->get('session')->getFlashBag()->add('success', 'Вулицю видалено');
            }
            else
            {
                throw new NotFoundHttpException('Вулицю не знайдено!');
            }
        }
        
        return $this->redirect( $this->generateUrl( 'crm_addresses_street_list'));
    }
}
