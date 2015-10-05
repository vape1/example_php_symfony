<?php

namespace Crm\AddressesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Crm\AddressesBundle\Services\StaticFunctions;
use Crm\AddressesBundle\Controller\HouseController;
use Crm\AddressesBundle\Entity\Brand;
use Crm\AddressesBundle\Form\Type\ParadType;
use Crm\AddressesBundle\Form\Type\BrandType;

class ParadController extends HouseController
{
    /**
     * @param string $class
     */
    public function __construct()
    {
        $this->class = 'Crm\AddressesBundle\Entity\Parad';
        $this->alias = 'p';
        $this->em_name = 'default';
    }
    
    public function indexAction()
    {
        if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_PARAD_ATTRIBUTE_READ')) )
        {
            throw new AccessDeniedException();
        }
        
        $id = $this->get('request')->get('view_id');
        
        if( $this->isReset() )
        {
            return $this->redirect( $this->generateUrl( $this->get('request')->get('_route'),array('view_id' => $id) ));
        }
        
        //settings for userViews
        $this->initUserView('parad',$id);
        //END settings for userViews
        
        $this->buildListFields();
        
        $this->getSortedListFields('parad');
        
        $items = $this->getListFields();
        
        $this->getEm()->buildQuery();
        
        $this->getQuery()
            ->select('p,h,s,sb,r,c,br')
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
        
        return $this->render('CrmAddressesBundle:Parad:list.html.twig', array(
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
     
        if($this->checkUserView('p_faza','list'))
        $this->addInList(array(
            'faza',
            $this->trans('p_faza','address'),
            'p',
            true,
            null,
            null,
            array('style' => 'text-align:center'),
            'getFaza'
        ));
        
        if($this->checkUserView('p_name','list'))
        $this->addInList(array(
            'name',
            $this->trans('p_name','address'),
            'p',
            true,
            null,
            null,
            array('style' => 'text-align:center'),
            'getParadName'
        ));
        
        if($this->checkUserView('p_accessParad','list'))
        $this->addInList(array(
            'accessParad',
            $this->trans('p_accessParad','address'),
            'p',
            true,
            null,
            null,
            array('style' => 'text-align:center'),
            'getAccessParad'
        ));
        
        if($this->checkUserView('p_commentAccessParad','list'))
        $this->addInList(array(
            'commentAccessParad',
            $this->trans('p_commentAccessParad','address'),
            'p',
            true,
            null,
            null,
            array('style' => 'text-align:center'),
            'getCommentAccessParad'
        ));
        
        if($this->checkUserView('p_addressKey','list'))
        $this->addInList(array(
            'addressKey',
            $this->trans('p_addressKey','address'),
            'p',
            true,
            null,
            null,
            array('style' => 'text-align:center'),
            'getAddressKey'
        ));
    
        if($this->checkUserView('p_bilinkStoyak','list'))
        $this->addInList(array(
            'bilinkStoyak',
            $this->trans('p_bilinkStoyak','address'),
            'p',
            true,
            null,
            null,
            array('style' => 'text-align:center'),
            'getBilinkStoyak'
        ));

        if($this->checkUserView('p_semafor','list'))
        $this->addInList(array(
            'semafor',
            $this->trans('p_semafor','address'),
            'p',
            true,
            null,
            null,
            array('style' => 'text-align:center'),
            'getSemafor'
        ));
        
        if($this->checkUserView('p_eprasysName','list'))
        $this->addInList(array(
            'eprasysName',
            $this->trans('p_eprasysName','address'),
            'p',
            true,
            null,
            null,
            array('link_id' => 'crm_addresses_parad_edit','style' => 'text-align:center','parent_id' => 'getParadId'),
            'getEprasysNameParad'
        ));
        
        if($this->checkUserView('p_dateConn','list'))
        $this->addInList(array(
            'dateConn',
            $this->trans('p_dateConn','address'),
            'p',
            true,
            'dateTimeFormat',
            null,
            array('style' => 'text-align:center'),
            'getDateConn'
        ));
        
    }
    
    /**
     * buildListFields
     * name,type,label,count,sort,condition_operator,options
     */
    public function buildFilterFields()
    {
        parent::buildFilterFields();
        
        if($this->checkUserView('p_name','filter'))
        $this->addInFilter(array(
            'p_name',
            'text_filter',
            $this->trans('p_name','address'),
            5,
            'light_text'
        ));
        
        if($this->checkUserView('p_accessParad','filter'))
        $this->addInFilter(array(
            'p_accessParad',
            'boolean_filter',
            $this->trans('p_accessParad','address')
        ));
    
        if($this->checkUserView('p_addressKey','filter'))
        $this->addInFilter(array(
            'p_addressKey',
            'text_filter',
            $this->trans('p_addressKey','address'),
            5,
            'light_text'
        ));
        
        if($this->checkUserView('p_faza','filter'))
        $this->addInFilter(array(
            'p_faza',
            'choice_filter',
            $this->trans('p_faza','address'),
            5,
            'light_text',
            array('sf_choice' => array(0 => '0', 15 => '15', 1 => '1', 2 => '2', 3 => '3'))
        ));
     

        if($this->checkUserView('p_bilinkStoyak','filter'))
        $this->addInFilter(array(
            'p_bilinkStoyak',
            'boolean_filter',
            $this->trans('p_bilinkStoyak','address'),
        ));
      
        if($this->checkUserView('p_semafor','filter'))
        $this->addInFilter(array(
            'p_semafor',
            'choice_filter',
            $this->trans('p_semafor','address'),
            5,
            'light_text',
            array('sf_choice' =>  array(1 => '1', 2 => '2', 3 => '3'))
        ));
       
        if($this->checkUserView('p_conditionParad','filter'))
        $this->addInFilter(array(
            'p_conditionParad',
            'text_filter',
            $this->trans('p_conditionParad','address'),
            5,
            'light_text'
        ));
        
        if($this->checkUserView('p_dateConn','filter'))
        $this->addInFilter(array(
            'p_dateConn',
            'date_filter',
            $this->trans('p_dateConn','address'),
            5
        ));
      
      
    }
    
    /**
     * editParadAction
     */
    public function editAction( Request $request, $id )
    {
        if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_PARAD_ATTRIBUTE_READ')) )
        {
            throw new AccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();
        
        $object = $em->getRepository($this->class)->find($id);
        if( !$object )
        {
            throw new NotFoundHttpException('Під’їзд не знайдено!');
        }
        $form = $this->createForm(new ParadType($object), $object, array(
                'action' => $this->generateUrl('crm_addresses_parad_edit',array(
                'id' => $object->getId()
            )),
                'security' => $this->get('security.context')
        ));
        
        $form->handleRequest($request);
        
        if ($form->isValid())
        {
            if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_PARAD_ATTRIBUTE_WRITE')) )
            {
                throw new AccessDeniedException();
            }
            
            $em->flush();
            
            $notice = $this->get('translator')->trans('Your changes were saved');
            $this->get('session')->getFlashBag()->add('success', $notice);
                
            return $this->redirect( $this->generateUrl( 'crm_addresses_parad_edit',array(
                'id' => $object->getId()
            )));
        }
        
        return $this->render('CrmAddressesBundle:Parad:edit.html.twig', array(
            'form' => $form->createView(),
            'parad' =>  $object
        ));
    }
    
    /**
     * newParadAction
     */
    public function newAction( Request $request, $house_id)
    {
        if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_NEW')) )
        {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $house = $em->getRepository('Crm\AddressesBundle\Entity\House')->find($house_id);
        
        if( !$house )
        {
            throw new NotFoundHttpException('Помилка! Будинок для прив’язки не знайдено!');
        }
        
        $object = new $this->class($house);
        
        $form = $this->createForm( new ParadType($object), $object, array(
            'action' => $this->generateUrl('crm_addresses_parad_new',array(
                'house_id' => $house_id,
            )),
            'security' => $this->get('security.context')
        ));
        
        $form->handleRequest($request);
            
            if( $form->isValid() ) 
            {
                $object->setEprasysName();
                $this->EntityManager()->persist($object);
                $this->EntityManager()->flush();
                
                $notice = $this->get('translator')->trans('Your changes were saved');
                $this->get('session')->getFlashBag()->add('success', $notice);
                
                return $this->redirect( $this->generateUrl( 'crm_addresses_parad_edit',array(
                    'id' => $object->getId()
                )));
            }
         
        return $this->render('CrmAddressesBundle:Parad:edit.html.twig', array(
            'form' => $form->createView(),
            'parad' => $object,
            'house' => $house
        ));
    }

    
    /**
     * deleteParad
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
            $object = $em->getRepository($this->class)->find($id);
            $house_id = $object->getHouseId();
            if( !$object )
            {
                throw new NotFoundHttpException('Під’їзд не знайдено!');
            }
            if( $object )
            {
                if($object->hasChildren())
                {
                    $text = $this->get('translator')->trans('has.children');
                    throw new NotFoundHttpException($text);
                }
                $log = $this->get('security.context')->getToken()->getUser()->getName().' :: '
                .$object->getStreetNameUa().", ".$object->getHouseName()." #". $object->getName().' -> delete';
                $em->remove( $object );
                $em->flush();
                StaticFunctions::writeLog(
                    $this->get('kernel')->getRootDir().'/logs/deleteParadAction.log',
                    array($log)
                );
                $this->get('session')->getFlashBag()->add('success', 'Під’їзд видалено');
            }
        }
        
        return $this->redirect( $this->generateUrl( 'crm_addresses_house_edit',array(
                    'id' => $house_id
                )));
    }
    
     /**
     * editBrandAction
     */
    public function editBrandAction( Request $request, $id )
    {
        if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_BRAND_READ')) )
        {
            throw new AccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();
        
        $object = $em->getRepository('Crm\AddressesBundle\Entity\Brand')->find($id);
        
        if( !$object )
        {
            throw new NotFoundHttpException('Обьект не знайдено!');
        }
        
        $form = $this->createForm(new BrandType($object), $object, array(
                'action' => $this->generateUrl('crm_addresses_brand_edit',array(
                'id' => $object->getId()
            )),
        ));
        
        $form->handleRequest($request);
        
        if ($form->isValid())
        {
            if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_BRAND_WRITE')) )
            {
                throw new AccessDeniedException();
            }
            $em->persist($object);
            $em->flush();
            
            $notice = $this->get('translator')->trans('Your changes were saved');
            $this->get('session')->getFlashBag()->add('success', $notice);
                
            return $this->redirect( $this->generateUrl( 'crm_addresses_parad_edit',array(
                'id' => $object->getParad()->getId()
            )));
        }
        
        return $this->render('CrmAddressesBundle:Brand:edit.html.twig', array(
            'form' => $form->createView(),
            'brand' =>  $object
        ));
    }
    
    /**
     * newBrandAction
     */
    public function newBrandAction( Request $request, $parad_id, $id)
    {
        if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_BRAND_WRITE')) )
        {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $parad = $em->getRepository('Crm\AddressesBundle\Entity\Parad')->find($parad_id);
        $brandType = $em->getRepository('Crm\AddressesBundle\Entity\BrandType')->find($id);
        
        if( !$parad )
        {
            throw new NotFoundHttpException('Помилка! Під’їзд для прив’язки не знайдено!');
        }
        
        $object = new Brand($parad,$brandType);
        
        $form = $this->createForm( new BrandType($object), $object, array(
            'action' => $this->generateUrl('crm_addresses_brand_new',array(
                    'parad_id' => $parad_id,
                    'id' => $id
            )),
        ));
        
        $form->handleRequest($request);
            
            if( $form->isValid() ) 
            {
                $this->EntityManager()->persist($object);
                $this->EntityManager()->flush();
                
                $notice = $this->get('translator')->trans('Your changes were saved');
                $this->get('session')->getFlashBag()->add('success', $notice);
                
                return $this->redirect( $this->generateUrl( 'crm_addresses_parad_edit',array(
                    'id' => $parad_id,
                )));
            }
         
        return $this->render('CrmAddressesBundle:Brand:edit.html.twig', array(
            'form' => $form->createView(),
            'brand' => $object,
        ));
    }

    
    /**
     * deleteBrand
     */
    public function deleteBrandAction( Request $request, $id )
    {
        if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_DELETE')) )
        {
            $error = $this->get('translator')->trans('You do not have enough privileges to carry out this action');
            $this->get('session')->getFlashBag()->add('error', $error);
        }
        else
        {
            $em = $this->getDoctrine()->getManager();
            $object = $em->getRepository('Crm\AddressesBundle\Entity\Brand')->find($id);
            $parad_id = $object->getParad()->getId();
            if( !$object )
            {
                throw new NotFoundHttpException('object не знайдено!');
            }
            if( $object )
            {
                $log = $this->getTotalUser()->getName().' :: '
                .$object->getBrandType().", Монтажник: ".$object->getWorker()." Дата установки". $object->getDateInstall()->format('Y-m-d').' -> delete';
                $em->remove( $object );
                $em->flush();
                StaticFunctions::writeLog(
                    $this->get('kernel')->getRootDir().'/logs/deleteBrandAction.log',
                    array($log)
                );
                $text = $object->getBrandType().' видалено!';
                $this->get('session')->getFlashBag()->add('success',  $text);
            }
        }
        
        return $this->redirect( $this->generateUrl( 'crm_addresses_parad_edit',array(
                    'id' => $parad_id
                )));
    }
}
