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
use Crm\AddressesBundle\Form\Type\RackType;

class RackController extends ParadController
{
    /**
     * @param string $class
     */
    public function __construct()
    {
        $this->class = 'Crm\AddressesBundle\Entity\Rack';
        $this->alias = 'rk';
        $this->em_name = 'default';
    }
    
    public function indexAction()
    {
        if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_RACK_READ')) )
        {
            throw new AccessDeniedException();
        }
        
        $id = $this->get('request')->get('view_id');
        
        if( $this->isReset() )
        {
            return $this->redirect( $this->generateUrl( $this->get('request')->get('_route'),array('view_id' => $id) ));
        }
        
        //settings for userViews
        $this->initUserView('rack',$id);
        //END settings for userViews
        
        $this->buildListFields();
        
        $this->getSortedListFields();
        
        $items = $this->getListFields();
        
        $this->getEm()->buildQuery();
        
        $this->getQuery()
            ->select('rk,h,s,sb,r,c,br,p')
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
        
        return $this->render('CrmAddressesBundle:Rack:list.html.twig', array(
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
        
        if($this->checkUserView('rk_eprasysName','list'))
        $this
        ->addInList(array(
            'eprasysName',
            $this->trans('rk_eprasysName','address'),
            'rk',
            true,
            null,
            null,
            array('link_id' => 'crm_addresses_rack_edit','style' => 'text-align:center','parent_id' => 'getRackId'),
            'getEprasysNameRack'
        ));
           
            
        if($this->checkUserView('rk_placeInstall','list'))
        $this->addInList(array(
            'placeInstall',
            $this->trans('rk_placeInstall','address'),
            'rk',
            true,
            null,
            null,
            array('style' => 'text-align:center')
        ));
        
        if($this->checkUserView('rk_keyNumber','list'))
        $this->addInList(array(
            'keyNumber',
            $this->trans('rk_keyNumber','address'),
            'rk',
            true,
            null,
            null,
            array('style' => 'text-align:center')
        ));
        
        if($this->checkUserView('rk_dateInstall','list'))
        $this->addInList(array(
            'dateInstall',
            $this->trans('rk_dateInstall','address'),
            'rk',
            true,
            'dateTimeFormat',
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
        
        if($this->checkUserView('rk_placeInstall','filter'))
        $this->addInFilter(array(
            'rk_placeInstall',
            'text_filter',
            $this->trans('rk_placeInstall','address'),
            5,
            'light_text'
        ));
        
        if($this->checkUserView('rk_eprasysName','filter'))
        $this->addInFilter(array(
            'rk_eprasysName',
            'text_filter',
            $this->trans('rk_eprasysName','address'),
            5,
            'light_text'
        ));
        
        if($this->checkUserView('rk_dateInstall','filter'))
        $this->addInFilter(array(
            'rk_dateInstall',
            'date_filter',
            $this->trans('rk_dateInstall','address'),
            5,
            'light_text'
        ));
       
    }
    
    /**
     * editRackAction
     */
    public function editAction( Request $request, $id )
    {
        if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_RACK_READ')) )
        {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $object = $em->getRepository($this->class)->find($id);
        
        if( !$object )
        {
            throw new NotFoundHttpException('Ящик не знайдено!');
        }
        
        $form = $this->createForm(new RackType($object), $object, array(
                'action' => $this->generateUrl('crm_addresses_rack_edit',array(
                'id' => $object->getId()
            )),
              
        ));
        
        $form->handleRequest($request);
        
        if ($form->isValid())
        {
            if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_RACK_WRITE')) )
            {
                throw new AccessDeniedException();
            }
            
            $em->flush();
            
            $notice = $this->get('translator')->trans('Your changes were saved');
            $this->get('session')->getFlashBag()->add('success', $notice);
                
            return $this->redirect( $this->generateUrl( 'crm_addresses_rack_edit',array(
                'id' => $object->getId()
            )));
        }
        
        return $this->render('CrmAddressesBundle:Rack:edit.html.twig', array(
            'form' => $form->createView(),
            'rack' => $object
        ));
    }
    
    /**
     * newRackAction
     */
    public function newAction( Request $request, $parad_id)
    {
        if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_ADD')) )
        {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $parad = $em->getRepository('Crm\AddressesBundle\Entity\Parad')->find($parad_id);
        
        $object = new $this->class($parad);
     
        $form = $this->createForm( new RackType($object), $object);
        
        $form->handleRequest($request);
         
            if( $form->isValid() ) 
            {
                //Автоматическое добавление суффикса EprasysName к дому 
                $object->setEprasysName();
             
                $this->EntityManager()->persist($object);
                $this->EntityManager()->flush();
                
                $notice = $this->get('translator')->trans('Your changes were saved');
                $this->get('session')->getFlashBag()->add('success', $notice);
                
                return $this->redirect( $this->generateUrl( 'crm_addresses_rack_edit',array(
                    'id' => $object->getId()
                )));
            }
         
        return $this->render('CrmAddressesBundle:Rack:edit.html.twig', array(
            'form' => $form->createView(),
            'rack' => $object,
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
            $parad_id = $object->getParad()->getId();
            if( $object)
            {
                if($object->hasChildren())
                {
                    $text = $this->get('translator')->trans('has.children');
                    throw new NotFoundHttpException($text);
                }
                
                $log = $this->getTotalUser()->getName().' :: '
                .$object->getEprasysName().', '
                .$object->getKeyNumber().' -> delete';
                
                $em->remove( $object  );
                $em->flush();
                
                StaticFunctions::writeLog(
                    $this->get('kernel')->getRootDir().'/logs/deleteRackAction.log',
                    array($log)
                );
                $this->get('session')->getFlashBag()->add('success', 'Ящик видалено');
            }
            else
            {
                throw new NotFoundHttpException('Ящик не знайдено!');
            }
        }
        
         return $this->redirect( $this->generateUrl( 'crm_addresses_parad_edit',array(
                    'id' => $parad_id
                )));
    }
}
