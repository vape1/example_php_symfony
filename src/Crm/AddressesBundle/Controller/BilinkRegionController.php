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

use Crm\AddressesBundle\Form\Type\BilinkRegionType;

class BilinkRegionController extends AdminInterfaceController
{
    /**
     * @param string $class
     */
    public function __construct()
    {
        parent::__construct('Crm\AddressesBundle\Entity\BilinkRegion','br');
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
            ->select('br')
        ;
        
        $this->buildFilterFields();
        $this->checkFilters();
        
        $pagination = $this->getPaginator(30);
        
        $filter_form = $this->getViewFiltersForm();
        
        return $this->render('CrmAddressesBundle:BilinkRegion:list.html.twig', array(
            'results'     => $pagination,
            'items'       => $items,
            'filter_form' => $filter_form,
        ));
    }
    
    /**
     * buildListFieldsCity
     * name,label,alias,sort,func,filter,options,method
     */
    public function buildListFields()
    {
        $this->addInList(array(
            'nameUa',
            $this->trans('br_nameUa','address'),
            'br',
            true,
            null,
            null,
            array('style' => 'text-align:center')
        ));

        $this
        ->addInList(array(
            'nameRu',
            $this->trans('br_nameRu','address'),
            'br',
            true,
            null,
            null,
            array()
        ));
        
        $this->addInList(array(
            'edit',
            $this->trans('edit','address'),
            null,
            false,
            null,
            null,
            array('link_id' => 'crm_addresses_bilink_region_edit','style' => 'text-align:center')
        ))
        ;
    }
    
    /**
     * buildListFieldsRegion
     * name,type,label,count,sort,condition_operator,options
     */
    public function buildFilterFields()
    {
        $this->addInFilter(array(
            'br_nameUa',
            'text_filter',
            $this->trans('br_nameUa','address'),
            5,
            'light_text'
        ));
        
         $this->addInFilter(array(
            'br_nameUa',
            'text_filter',
            $this->trans('br_nameUa','address'),
            5,
            'light_text'
        ));
    }
    
    /**
     * editRegionAction
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
            throw new NotFoundHttpException('bilink район не знайдено!');
        }
        
        $form = $this->createForm(new BilinkRegionType($object), $object, array(
                'action' => $this->generateUrl('crm_addresses_bilink_region_edit',array(
                    'id' => $object->getId()
                )),
        ));
        
        $form->handleRequest($request);
        
        if ($form->isValid())
        {
            if ( false === $this->isZkGranded(array('ROLE_REGION_EDIT')) )
            {
                throw new AccessDeniedException();
            }
            
            $em->flush();
            
            $notice = $this->get('translator')->trans('Your changes were saved');
            $this->get('session')->getFlashBag()->add('notice', $notice);
                
            return $this->redirect( $this->generateUrl( 'crm_addresses_bilink_region_edit',array(
                'id' => $object->getId()
            )));
        }
        
        return $this->render('CrmAddressesBundle:BilinkRegion:edit.html.twig', array(
            'form' => $form->createView(),
            'id' => $object->getId()
        ));
    }
    
    /**
     * newRegionAction
     */
    public function newAction( Request $request, $id)
    {
        if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_ADD')) )
        {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $object = new $this->class();
        
        $form = $this->createForm( new BilinkRegionType($object), $object);
        
        $form->handleRequest($request);
            
            if( $form->isValid() ) 
            {
                $this->EntityManager()->persist($object);
                $this->EntityManager()->flush();
                
                $notice = $this->get('translator')->trans('Your changes were saved');
                $this->get('session')->getFlashBag()->add('notice', $notice);
                
                return $this->redirect( $this->generateUrl( 'crm_addresses_bilink_region_edit',array(
                    'id' => $object->getId()
                )));
            }
         
        return $this->render('CrmAddressesBundle:BilinkRegion:edit.html.twig', array(
            'form' => $form->createView(),
            'bilink_region' => $object,
        ));
    }

    
     /**
     * deleteRegion
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
                .$object ->getNameUa().' -> delete';
                $em->remove( $object );
                $em->flush();
                StaticFunctions::writeLog(
                    $this->get('kernel')->getRootDir().'/logs/deleteBilinkRegionAction.log',
                    array($log)
                );
                $this->get('session')->getFlashBag()->add('notice', 'bilink регіон видалено');
            }
            else
            {
                throw new NotFoundHttpException('bilink регіон не знайдено!');
            }
        }
        
        return $this->redirect( $this->generateUrl( 'crm_addresses_bilink_region_list'));
    }
}
