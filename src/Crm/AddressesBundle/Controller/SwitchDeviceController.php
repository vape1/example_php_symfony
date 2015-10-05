<?php

namespace Crm\AddressesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
#use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Crm\AddressesBundle\Controller\ParadController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Crm\AddressesBundle\Services\StaticFunctions;
use Crm\AddressesBundle\Form\Type\SwitchDeviceType;

class SwitchDeviceController extends ParadController
{
    /**
     * @param string $class
     */
    public function __construct()
    {
        $this->class = 'Crm\AddressesBundle\Entity\SwitchDevice';
        $this->alias = 'sd';
        $this->em_name = 'default';
    }
    
    public function indexAction()
    {
        if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_VIEW')) )
        {
            throw new AccessDeniedException();
        }
        
        $id = $this->get('request')->get('view_id');
        
        if( $this->isReset() )
        {
            return $this->redirect( $this->generateUrl( $this->get('request')->get('_route'),array('view_id' => $id) ));
        }
        
        //settings for userViews
        $this->initUserView('switch_device',$id);
        //END settings for userViews
        
        $this->buildListFields();
        
        $this->getSortedListFields();
        
        $items = $this->getListFields();
        
        $this->getEm()->buildQuery();
        
        $this->getQuery()
            ->select('sd,rk,h,s,sb,r,c,br,p')
            ->leftJoin('sd.rack','rk')
            ->leftJoin('rk.parad','p')
            ->leftJoin('p.house','h')
            ->leftJoin('h.subRegion','sb')
            ->leftJoin('h.region','r')
            ->leftJoin('h.street','s')
            ->leftJoin('r.city','c')
            ->leftJoin('sb.bilinkRegion','br')
        ;
        
        $this->buildFilterFields();
        $this->checkFilters();
        
        $pagination = $this->getPaginator(30);
        
        $filter_form = $this->getViewFiltersForm();
        
        return $this->render('CrmAddressesBundle:SwitchDevice:list.html.twig', array(
            'results'     => $pagination,
            'items'       => $items,
            'filter_form' => $filter_form,
            'view_id'     => $id,
        ));
    }
    
    /**
     * buildListFields Rack
     * name,label,alias,sort,func,filter,options,method
     */
    public function buildListFields()
    {
        parent::buildListFields();
        
        if($this->checkUserView('sd_eprasysName','list'))
        $this
        ->addInList(array(
            'eprasysName',
            $this->trans('sd_eprasysName','address'),
            'sd',
            true,
            null,
            null,
            array('link_id' => 'crm_addresses_switch_device_edit','style' => 'text-align:center','parent_id' => 'getSwitchDeviceId')
           
        ));
        
        if($this->checkUserView('sd_ringNum','list'))
        $this
        ->addInList(array(
            'ringNum',
            $this->trans('sd_ringNum','address'),
            'sd',
            true,
            null,
            null,
            array('style' => 'text-align:center')
          
        ));
        
        if($this->checkUserView('sd_dateInstall','list'))
        $this
        ->addInList(array(
            'dateInstall',
            $this->trans('sd_dateInstall','address'),
            'sd',
            true,
            'dateTimeFormat',
            null,
            array('style' => 'text-align:center')
          
        ));
        
        if($this->checkUserView('sd_switchType','list'))
        $this
        ->addInList(array(
            'switchType',
            $this->trans('sd_switchType','address'),
            'sd',
            true,
            null,
            null,
            array('style' => 'text-align:center')
          
        ));
        
        if($this->checkUserView('sd_installer','list'))
        $this
        ->addInList(array(
            'installer',
            $this->trans('sd_installer','address'),
            'sd',
            true,
            null,
            null,
            array('style' => 'text-align:center')
          
        ));
        
        if($this->checkUserView('sd_onControl','list'))
        $this
        ->addInList(array(
            'onControl',
            $this->trans('sd_onControl','address'),
            'sd',
            true,
            null,
            null,
            array('style' => 'text-align:center')
          
        ));
        
        if($this->checkUserView('sd_macAddress','list'))
        $this
        ->addInList(array(
            'macAddress',
            $this->trans('sd_macAddress','address'),
            'sd',
            true,
            null,
            null,
            array('style' => 'text-align:center')
          
        ));
        
        if($this->checkUserView('sd_serialNum','list'))
        $this
        ->addInList(array(
            'serialNum',
            $this->trans('sd_serialNum','address'),
            'sd',
            true,
            null,
            null,
            array('style' => 'text-align:center')
          
        ));
        
        
    }
    
    /**
     * buildListFields Rack
     * name,type,label,count,sort,condition_operator,options
     */
    public function buildFilterFields()
    {
        parent::buildFilterFields();
        
        if($this->checkUserView('sd_ringNum','filter'))
        $this->addInFilter(array(
            'sd_ringNum',
            'text_filter',
            $this->trans('sd_ringNum','address'),
            5,
            'light_text'
        ));
        
        if($this->checkUserView('sd_eprasysName','filter'))
        $this->addInFilter(array(
            'sd_eprasysName',
            'text_filter',
            $this->trans('sd_eprasysName','address'),
            5,
            'light_text'
        ));
        
        if($this->checkUserView('sd_dateInstall','filter'))
        $this->addInFilter(array(
            'sd_dateInstall',
            'date_filter',
            $this->trans('sd_dateInstall','address'),
            5,
            'light_text'
        ));
        
        if($this->checkUserView('sd_switchType','filter'))
        $this->addInFilter(array(
            'sd_switchType',
            'text_filter',
            $this->trans('sd_switchType','address'),
            5,
            'smal_int',
            array(
                'entity_class' => 'Crm\AddressesBundle\Entity\SwitchType',
            )
        ));
        
        if($this->checkUserView('sd_installer','filter'))
        $this->addInFilter(array(
            'sd_installer',
             'entity_filter',
            $this->trans('sd_installer','address'),
            5,
            'smal_int',
            array(
                'entity_class' => 'Zk\UserBundle\Entity\User',
            )
        ));
       
        if($this->checkUserView('sd_onControl','filter'))
        $this->addInFilter(array(
            'sd_onControl',
            'boolean_filter',
            $this->trans('sd_onControl','address')
        ));
       
        if($this->checkUserView('sd_macAddress','filter'))
        $this->addInFilter(array(
            'sd_macAddress',
            'text_filter',
            $this->trans('sd_macAddress','address'),
            5,
            'light_text'
        ));
        
        if($this->checkUserView('sd_serialNum','filter'))
        $this->addInFilter(array(
            'sd_serialNum',
            'text_filter',
            $this->trans('sd_serialNum','address'),
            5,
            'light_text'
        ));
       
    }
    
    /**
     * editRackAction
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
        
        $form = $this->createForm(new SwitchDeviceType($object), $object, array(
                'action' => $this->generateUrl('crm_addresses_switch_device_edit',array(
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
                
            return $this->redirect( $this->generateUrl( 'crm_addresses_switch_device_edit',array(
                'id' => $object->getId()
            )));
        }
        
        return $this->render('CrmAddressesBundle:SwitchDevice:edit.html.twig', array(
            'form' => $form->createView(),
            'switch' => $object
        ));
    }
    
    /**
     * newRackAction
     */
    public function newAction( Request $request, $rack_id)
    {
        if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_ADD')) )
        {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $rack = $em->getRepository('Crm\AddressesBundle\Entity\Rack')->find($rack_id);
        
        $object = new $this->class($rack);
     
        $form = $this->createForm( new SwitchDeviceType($object), $object);
        
        $form->handleRequest($request);
         
            if( $form->isValid() ) 
            {
                //Автоматическое добавление суффикса EprasysName к дому 
                $object->setEprasysName();
                
                $this->EntityManager()->persist($object);
                $this->EntityManager()->flush();
                
                $notice = $this->get('translator')->trans('Your changes were saved');
                $this->get('session')->getFlashBag()->add('success', $notice);
                
                return $this->redirect( $this->generateUrl( 'crm_addresses_switch_device_edit',array(
                    'id' => $object->getId()
                )));
            }
         
        return $this->render('CrmAddressesBundle:SwitchDevice:edit.html.twig', array(
            'form' => $form->createView(),
            'switch' => $object,
        ));
    }

    
    /**
     * deleteRackAbonement
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
            $rack_id = $object->getRack()->getId();
            if( $object)
            {
                $log = $this->getTotalUser()->getName().' :: '
                .$object->getName().' -> delete';
                
                $em->remove( $object  );
                $em->flush();
                
                StaticFunctions::writeLog(
                    $this->get('kernel')->getRootDir().'/logs/deleteSwitchDeviceAction.log',
                    array($log)
                );
                $this->get('session')->getFlashBag()->add('success', 'Свіч видалено');
            }
            else
            {
                throw new NotFoundHttpException('Свіч не знайдено!');
            }
        }
        
        return $this->redirect( $this->generateUrl( 'crm_addresses_rack_edit',array(
                    'id' => $rack_id
                )));
    }
}
