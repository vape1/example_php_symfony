<?php

namespace Crm\AddressesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
#use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Crm\AddressesBundle\Controller\StreetController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Crm\AddressesBundle\Services\StaticFunctions;

use Crm\AddressesBundle\Form\Type\HouseType;

class HouseController extends StreetController
{
    /**
     * @param string $class
     */
    public function __construct()
    {
        $this->class = 'Crm\AddressesBundle\Entity\House';
        $this->alias = 'h';
        $this->em_name = 'default';
    }
    
    public function indexAction()
    {
        if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_HOUSE_ATTRIBUTE_READ')) )
        {
            throw new AccessDeniedException();
        }
        
        $id = $this->get('request')->get('view_id');
        
        if( $this->isReset() )
        {
            return $this->redirect( $this->generateUrl( $this->get('request')->get('_route'),array('view_id' => $id) ));
        }
        
        //settings for userViews
        $this->initUserView('house',$id);
        //END settings for userViews
        
        $this->buildListFields();
        
        $this->getSortedListFields();
        
        $items = $this->getListFields();
        
        $this->getEm()->buildQuery();
        
        $this->getQuery()
            ->select('h,s,sb,r,c,br')
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
        
        return $this->render('CrmAddressesBundle:House:list.html.twig', array(
            'results'     => $pagination,
            'items'       => $items,
            'filter_form' => $filter_form,
            'view_id'     => $id,
        ));
    }
    
    /**
     * buildListFields
     * name,label,alias,sort,func,filter,options,method
     */
    public function buildListFields()
    {
        parent::buildListFields();
        
        if($this->checkUserView('r_nameUa','list'))
        $this
        ->addInList(array(
            'nameUa',
            $this->trans('r_nameUa','address'),
            'r',
            true,
            null,
            null,
            array('style' => 'text-align:center'),
            'getRegion'
        ));
        
        if($this->checkUserView('br_nameUa','list'))
        $this->addInList(array(
            'nameUa',
            $this->trans('br_nameUa','address'),
            'br',
            true,
            null,
            null,
            array('style' => 'text-align:center'),
            'getBilinkRegion'
        ));
        
        if($this->checkUserView('sb_nameUa','list'))
        $this->addInList(array(
            'nameUa',
            $this->trans('sb_nameUa','address'),
            'sb',
            true,
            null,
            null,
            array('style' => 'text-align:center'),
            'getSubRegion'
        ));
        
        if($this->checkUserView('h_eprasysName','list'))
        $this->addInList(array(
            'eprasysName',
            $this->trans('h_eprasysName','address'),
            'h',
            true,
            null,
            null,
            array('link_id' => 'crm_addresses_house_edit','style' => 'text-align:center','parent_id' => 'getHouseId'),
            'getEprasysNameHouse'
        ));
        
        if($this->checkUserView('h_name','list'))
        $this->addInList(array(
            'name',
            $this->trans('h_name','address'),
            'h',
            true,
            null,
            null,
            array('style' => 'text-align:center'),
            'getHouseName'
        ))
        ;
        
        if($this->checkUserView('h_prorabotka','list'))
        $this->addInList(array(
            'prorabotka',
            $this->trans('h_prorabotka','address'),
            'h',
            true,
            null,
            null,
            array('style' => 'text-align:center'),
            'getProrabotka'
        ))
        ;
        
        if($this->checkUserView('h_conditionHouse','list'))
        $this->addInList(array(
            'conditionHouse',
            $this->trans('h_conditionHouse','address'),
            'h',
            true,
            null,
            null,
            array('style' => 'text-align:center'),
            'getProrabotka'
        ))
        ;
    }
    
    /**
     * buildListFields
     * name,type,label,count,sort,condition_operator,options
     */
    public function buildFilterFields()
    {
        parent::buildFilterFields();
        if($this->checkUserView('r_nameUa','filter'))
        $this
        ->addInFilter(array(
            'r_nameUa',
            'entity_filter',
            $this->trans('r_nameUa','address'),
            5,
            'smal_int',
            array(
                'entity_class' => 'Crm\AddressesBundle\Entity\Region',
            )
        ));
        
        if($this->checkUserView('br_nameUa','filter'))
        $this->addInFilter(array(
            'br_nameUa',
            'entity_filter',
            $this->trans('br_nameUa','address'),
            5,
            'smal_int',
            array(
                'entity_class' => 'Crm\AddressesBundle\Entity\BilinkRegion',
            )
        ));
        
        if($this->checkUserView('sb_nameUa','filter'))
        $this->addInFilter(array(
            'sb_nameUa',
            'entity_filter',
            $this->trans('sb_nameUa','address'),
            5,
            'smal_int',
            array(
                'entity_class' => 'Crm\AddressesBundle\Entity\SubRegion',
            )
        ));
        
        if($this->checkUserView('h_eprasysName','filter'))
        $this->addInFilter(array(
            'h_eprasysName',
            'text_filter',
            $this->trans('h_eprasysName','address'),
            5,
            'light_text'
        ));
       
    }
    
    /**
     * editAction
     */
    public function editAction( Request $request, $id )
    {
        if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_HOUSE_ATTRIBUTE_READ')) )
        {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $object = $em->getRepository($this->class)->find($id);
        
        $bilink_regions =$em->getRepository('Crm\AddressesBundle\Entity\BilinkRegion')->findAll();
        
        if( !$object )
        {
            throw new NotFoundHttpException('Будинок не знайдено!');
        }
        
        $form = $this->createForm(new HouseType($object), $object, array(
                'action' => $this->generateUrl('crm_addresses_house_edit',array(
                'id' => $object->getId()
            )),
                'security' => $this->get('security.context')
        ));
        
        $form->handleRequest($request);
        
        if ($form->isValid())
        {
            if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_HOUSE_ATTRIBUTE_WRITE')) )
            {
                throw new AccessDeniedException();
            }
            
            $em->flush();
            
            $notice = $this->get('translator')->trans('Your changes were saved');
            $this->get('session')->getFlashBag()->add('success', $notice);
                
            return $this->redirect( $this->generateUrl( 'crm_addresses_house_edit',array(
                'id' => $object->getId()
            )));
        }
        
        return $this->render('CrmAddressesBundle:House:edit.html.twig', array(
            'form' => $form->createView(),
            'house' => $object,
            'bilink_regions' => $bilink_regions
            
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
        
        $bilink_regions =$em->getRepository('Crm\AddressesBundle\Entity\BilinkRegion')->findAll();
        
        $form = $this->createForm( new HouseType($object), $object, array(
                'security' => $this->get('security.context')
        ));
        
        $form->handleRequest($request);
         
            if( $form->isValid() ) 
            {
                //Автоматическое добавление суффикса EprasysName к дому 
                $eprasys_name_house = StaticFunctions::generateEprasys(
                                        $object->getStreet()->getEprasysName(),
                                        $object->getName(),
                                        'P-');
                  
                $object->setEprasysName($eprasys_name_house);
    
                $this->EntityManager()->persist($object);
                $this->EntityManager()->flush();
                
                $notice = $this->get('translator')->trans('Your changes were saved');
                $this->get('session')->getFlashBag()->add('success', $notice);
                
                return $this->redirect( $this->generateUrl( 'crm_addresses_house_edit',array(
                    'id' => $object->getId()
                )));
            }
         
        return $this->render('CrmAddressesBundle:House:edit.html.twig', array(
            'form' => $form->createView(),
            'house' => $object,
            'bilink_regions' => $bilink_regions
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
                .$object->getStreetNameUa().', '
                .$object->getName().' '.$object->getEprasysName().' -> delete';
                
                $em->remove( $object  );
                $em->flush();
                
                StaticFunctions::writeLog(
                    $this->get('kernel')->getRootDir().'/logs/deleteHouseAction.log',
                    array($log)
                );
                $this->get('session')->getFlashBag()->add('success', 'Будинок видалено');
            }
            else
            {
                throw new NotFoundHttpException('Будинок не знайдено!');
            }
        }
        
        return $this->redirect( $this->generateUrl( 'crm_addresses_house_list'));
    }
    
     /**
     *   subRegions Action (ajax)
     */
    public function subRegionsAction( $val )
    {
        $arr = array();
        $em = $this->getDoctrine()->getManager();
        $sub_regions = $em->getRepository('Crm\AddressesBundle\Entity\SubRegion')->findByBilinkRegion($val);
        foreach($sub_regions as $reg)
        {
            $arr[$reg->getId()] = $reg->getNameRu();
        }
        
        $response = json_encode( $arr );
   

        return new Response( $response, 200, array('Content-Type'=>'application/json'));
    }
}
