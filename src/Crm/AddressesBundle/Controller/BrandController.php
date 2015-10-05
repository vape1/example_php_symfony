<?php

namespace Crm\AddressesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Crm\AddressesBundle\Services\StaticFunctions;
use Crm\AddressesBundle\Controller\ParadController;
use Crm\AddressesBundle\Form\Type\BrandType;

class BrandController extends ParadController
{
    /**
     * @param string $class
     */
    public function __construct()
    {
        $this->class = 'Crm\AddressesBundle\Entity\Brand';
        $this->alias = 'brd';
        $this->em_name = 'default';
    }
    
    public function indexAction()
    {
        // echo'<pre>';print_r(array('asd'));echo'</pre>';exit;
        if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_PARAD_ATTRIBUTE_READ')) )
        {
            throw new AccessDeniedException();
        }
        
        if( $this->isReset() )
        {
            return $this->redirect( $this->generateUrl( $this->get('request')->get('_route') ) );
        }
        
        //settings for userViews
        
        $this->initUserView('brand',0);
        //END settings for userViews
     
        $type_id = $this->get('request')->get('type_id');
        $this->buildListFields();
        $this->getSortedListFields();
        $items = $this->getListFields();
       
        $this->getEm()->buildQuery();
        
        $this->getQuery()
            ->select('brd,p,h,s,sb,r,c,br')
            ->leftJoin('brd.parad','p')
            ->leftJoin('p.house','h')
            ->leftJoin('h.subRegion','sb')
            ->leftJoin('h.region','r')
            ->leftJoin('h.street','s')
            ->leftJoin('r.city','c')
            ->leftJoin('sb.bilinkRegion','br')
            ->leftJoin('brd.brandType','bt')
            ->where('bt.id = :id')
            ->setParameter('id', $type_id)
        ;
        
        $this->buildFilterFields();
        
        $this->checkFilters();
        
        $pagination = $this->getPaginator(30);
        
        $filter_form = $this->getViewFiltersForm();
        
        return $this->render('CrmAddressesBundle:Brand:list.html.twig', array(
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
        $type_id = $this->get('request')->get('type_id');
        parent::buildListFields();
     
        
        $this->addInList(array(
            'installer',
            $this->trans('brd_installer','address'),
            'brd',
            true,
            null,
            null,
            array('style' => 'text-align:center')
        ));
        
        $this->addInList(array(
                'descr',
                $this->trans('brd_descr','address'),
                'brd',
                true,
                null,
                null,
                array('style' => 'text-align:center')
            ));
        
        $this->addInList(array(
                'dateInstall',
                $this->trans('brd_dateInstall','address'),
                'brd',
                true,
                'dateTimeFormat',
                null,
                array('style' => 'text-align:center')
            ));
        
        if($type_id == 3)
        {
            $this->addInList(array(
                'prom_door_parad',
                $this->trans('brd_prom_door_parad','address'),
                'brd',
                true,
                null,
                'yes_no',
                array('style' => 'text-align:center')
            ));
            
            $this->addInList(array(
                'prom_lift_door',
                $this->trans('brd_prom_lift_door','address'),
                'brd',
                true,
                null,
                'yes_no',
                array('style' => 'text-align:center')
            ));
            
            $this->addInList(array(
                'prom_shield',
                $this->trans('brd_prom_shield','address'),
                'brd',
                true,
                null,
                'yes_no',
                array('style' => 'text-align:center')
            ));
        }
    }
    
    /**
     * buildListFields
     * name,type,label,count,sort,condition_operator,options
     */
    public function buildFilterFields()
    {
        parent::buildFilterFields();
        
      
        $this->addInFilter(array(
            'brd_installer',
            'text_filter',
            $this->trans('brd_installer','address'),
            5,
            'light_text'
        ));
    }
    
   
    
     /**
     * editBrandAction
     */
    public function editAction( Request $request, $id )
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
    public function newAction( Request $request, $parad_id)
    {
        if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_BRAND_WRITE')) )
        {
            throw new AccessDeniedException();
        }
        
        $id = $this->get('request')->get('id');
         
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
