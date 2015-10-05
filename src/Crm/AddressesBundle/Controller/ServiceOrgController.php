<?php

namespace Crm\AddressesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
#use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Zk\InterfaceBundle\AdminInterface\AdminInterfaceController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Crm\AddressesBundle\Services\StaticFunctions;
use Crm\AddressesBundle\Entity\ServiceOrgDep;
use Crm\AddressesBundle\Form\Type\ServiceOrgType;
use Crm\AddressesBundle\Form\Type\ServiceOrgDepType;

class ServiceOrgController extends AdminInterfaceController
{
     /**
     * @param string $class
     */
    public function __construct()
    {
        parent::__construct('Crm\AddressesBundle\Entity\ServiceOrg','so');
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
            ->select('so')
        ;
        
        $this->buildFilterFields();
        $this->checkFilters();
        
        $pagination = $this->getPaginator(30);
        
        $filter_form = $this->getViewFiltersForm();
        
        return $this->render('CrmAddressesBundle:ServiceOrg:list.html.twig', array(
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
            'name',
            $this->trans('so_name','address'),
            'so',
            true,
            null,
            null,
            array('style' => 'text-align:center'),
        ))
        ->addInList(array(
            'edit',
            $this->trans('edit','address'),
            null,
            false,
            null,
            null,
            array('link_id' => 'crm_addresses_service_org_edit','style' => 'text-align:center')
        ))
        ;
    }
    
    /**
     * buildListFields
     * name,type,label,count,sort,condition_operator,options
     */
    public function buildFilterFields()
    {
        $this->addInFilter(array(
            'so_name',
            'text_filter',
            $this->trans('so_name','address'),
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
        if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_VIEW')) )
        {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $object = $em->getRepository($this->class)->find($id);
        
        if( !$object )
        {
            throw new NotFoundHttpException('Організацію не знайдено!');
        }
        
        $form = $this->createForm(new ServiceOrgType($object), $object, array(
                'action' => $this->generateUrl('crm_addresses_service_org_edit',array(
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
                
            return $this->redirect( $this->generateUrl( 'crm_addresses_service_org_edit',array(
                'id' => $object->getId()
            )));
        }
        
        return $this->render('CrmAddressesBundle:ServiceOrg:edit.html.twig', array(
            'form' => $form->createView(),
            'service_org' => $object
        ));
    }
    
    /**
     * newAction
     */
    public function newAction( Request $request)
    {
        if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_ADD')) )
        {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $object = new $this->class();
        
        $form = $this->createForm( new ServiceOrgType($object), $object);
        
        $form->handleRequest($request);
         
            if( $form->isValid() ) 
            {
                $this->EntityManager()->persist($object);
                $this->EntityManager()->flush();
                
                $notice = $this->get('translator')->trans('Your changes were saved');
                $this->get('session')->getFlashBag()->add('success', $notice);
                
                return $this->redirect( $this->generateUrl( 'crm_addresses_service_org_edit',array(
                    'id' => $object->getId()
                )));
            }
         
        return $this->render('CrmAddressesBundle:ServiceOrg:edit.html.twig', array(
            'form' => $form->createView(),
            'service_org' => $object,
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
            if( $object)
            {
                if($object->hasChildren())
                {
                    $text = $this->get('translator')->trans('has.children');
                    throw new NotFoundHttpException($text);
                }
                
                $log = $this->get('security.context')->getToken()->getUser()->getName().' :: '
                .$object->getName().' -> delete';
                
                $em->remove($object);
                $em->flush();
                
                StaticFunctions::writeLog(
                    $this->get('kernel')->getRootDir().'/logs/deleteServiceOrgAction.log',
                    array($log)
                );
                $this->get('session')->getFlashBag()->add('success', 'Організацію видалено');
            }
            else
            {
                throw new NotFoundHttpException('Організацію не знайдено!');
            }
        }
        
        return $this->redirect( $this->generateUrl( 'crm_addresses_service_org_list'));
    }
    
    /**
     * editAction
     */
    public function editDepAction( Request $request, $id )
    {
        if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_VIEW')) )
        {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $object = $em->getRepository('Crm\AddressesBundle\Entity\ServiceOrgDep')->find($id);
        
        if( !$object )
        {
            throw new NotFoundHttpException('Організацію не знайдено!');
        }
        
        $form = $this->createForm(new ServiceOrgDepType($object), $object, array(
                'action' => $this->generateUrl('crm_addresses_service_org_dep_edit',array(
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
                
            return $this->redirect( $this->generateUrl( 'crm_addresses_service_org_dep_edit',array(
                'id' => $object->getId()
            )));
        }
        
        return $this->render('CrmAddressesBundle:ServiceOrg:editDep.html.twig', array(
            'form' => $form->createView(),
            'service_org' => $object->getServiceOrg()
        ));
    }
    
    /**
     * newAction
     */
    public function newDepAction( Request $request, $org_id)
    {
        if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_ADD')) )
        {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $service_org = $em->getRepository($this->class)->find($org_id);
        
        $object = new ServiceOrgDep($service_org);
        
        $form = $this->createForm( new ServiceOrgDepType($object), $object);
        
        $form->handleRequest($request);
         
            if( $form->isValid() ) 
            {
                $this->EntityManager()->persist($object);
                $this->EntityManager()->flush();
                
                $notice = $this->get('translator')->trans('Your changes were saved');
                $this->get('session')->getFlashBag()->add('success', $notice);
                
                return $this->redirect( $this->generateUrl( 'crm_addresses_service_org_dep_edit',array(
                    'id' => $object->getId()
                )));
            }
         
        return $this->render('CrmAddressesBundle:ServiceOrg:editDep.html.twig', array(
            'form' => $form->createView(),
            'service_org' => $service_org
        ));
    }

    
    /**
     * deleteAbonement
     */
    public function deleteDepAction( Request $request, $id )
    {
        if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_DELETE')) )
        {
            $error = $this->get('translator')->trans('You do not have enough privileges to carry out this action');
            $this->get('session')->getFlashBag()->add('error', $error);
        }
        else
        {
            $em = $this->getDoctrine()->getManager();
            $object  = $em->getRepository('Crm\AddressesBundle\Entity\ServiceOrgDep')->find($id);
            
            if( $object)
            {
                $service_org_id = $object->getServiceOrg()->getId();
                
                $log = $this->get('security.context')->getToken()->getUser()->getName().' :: '
                .$object->getServiceOrg()->getName().' '.$object->getName().' -> delete';
                
                $em->remove($object);
                $em->flush();
                
                StaticFunctions::writeLog(
                    $this->get('kernel')->getRootDir().'/logs/deleteServiceOrgDepAction.log',
                    array($log)
                );
                $this->get('session')->getFlashBag()->add('success', 'Підрозділ видалено');
            }
            else
            {
                throw new NotFoundHttpException('Підрозділ не знайдено!');
            }
        }
        
        return $this->redirect( $this->generateUrl( 'crm_addresses_service_org_edit', array('id' => $service_org_id) ));
    }
    
}
