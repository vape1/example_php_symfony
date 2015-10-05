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

use Crm\AddressesBundle\Form\Type\FlatType;

class FlatController extends ParadController
{
    /**
     * @param string $class
     */
    public function __construct()
    {
        $this->class = 'Crm\AddressesBundle\Entity\Flat';
        $this->alias = 'f';
        $this->em_name = 'default';
    }
    
    public function indexAction()
    {
        if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_FLAT_ATTRIBUTE_READ')) )
        {
            throw new AccessDeniedException();
        }
        
        $id = $this->get('request')->get('view_id');
        
        if( $this->isReset() )
        {
            return $this->redirect( $this->generateUrl( $this->get('request')->get('_route'),array('view_id' => $id) ));
        }
        
        //settings for userViews
        $this->initUserView('flat',$id);
        //END settings for userViews
        
        $this->buildListFields();
        
        $this->getSortedListFields('flat');
        
        $items = $this->getListFields();
        
        $this->getEm()->buildQuery();
        
        $this->getQuery()
            ->select('f,p,h,s,sb,r,c,br')
            ->leftJoin('f.parad','p')
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
        
        return $this->render('CrmAddressesBundle:Flat:list.html.twig', array(
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
     
        if($this->checkUserView('f_name','list'))
        $this->addInList(array(
            'name',
            $this->trans('f_name','address'),
            'f',
            true,
            null,
            null,
            array('link_id' => 'crm_addresses_flat_edit','style' => 'text-align:center')
        ));
       
        if($this->checkUserView('f_rival','list'))
        $this->addInList(array(
            'rival',
            $this->trans('f_rival','address'),
            'f',
            true,
            null,
            null,
            array('style' => 'text-align:center')
        ));
     
        if($this->checkUserView('f_status','list'))
        $this->addInList(array(
            'status',
            $this->trans('f_status','address'),
            'f',
            true,
            null,
            null,
            array('style' => 'text-align:center')
        ));
        
        if($this->checkUserView('f_statusDescr','list'))
        $this->addInList(array(
            'statusDescr',
            $this->trans('f_statusDescr','address'),
            'f',
            true,
            null,
            null,
            array('style' => 'text-align:center')
        ));
        
        if($this->checkUserView('f_flatDescr','list'))
        $this->addInList(array(
            'flatDescr',
            $this->trans('f_flatDescr','address'),
            'f',
            true,
            null,
            null,
            array('style' => 'text-align:center')
        ));
    }
    
    /**
     * buildListFields
     * name,type,label,count,sort,condition_operator,options
     */
    public function buildFilterFields()
    {
        parent::buildFilterFields();
        
        if($this->checkUserView('f_name','filter'))
        $this->addInFilter(array(
            'f_name',
            'text_filter',
            $this->trans('f_name','address'),
            5,
            'light_text'
        ));
        
        if($this->checkUserView('f_status','filter'))
        $this->addInFilter(array(
            'f_status',
            'text_filter',
            $this->trans('f_status','address'),
            5,
            'light_text'
        ));
       
        if($this->checkUserView('f_statusDescr','filter'))
        $this->addInFilter(array(
            'f_statusDescr',
            'text_filter',
            $this->trans('f_statusDescr','address'),
            5,
            'light_text'
        ));
        
        if($this->checkUserView('f_flatDescr','filter'))
        $this->addInFilter(array(
            'f_flatDescr',
            'text_filter',
            $this->trans('f_flatDescr','address'),
            5,
            'light_text'
        ));
        
       
        if($this->checkUserView('f_rival','filter'))
        $this->addInFilter(array(
            'f_rival',
            'text_filter',
            $this->trans('f_rival','address'),
            5,
            'light_text'
        ));
        
    }
    
    /**
     * editAction
     */
    public function editAction( Request $request, $id )
    {
        if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_FLAT_ATTRIBUTE_READ')) )
        {
            throw new AccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();
        
        $object = $em->getRepository($this->class)->find($id);
        if( !$object )
        {
            throw new NotFoundHttpException('Квартиру не знайдено!');
        }
        $form = $this->createForm(new FlatType($object), $object, array(
                'action' => $this->generateUrl('crm_addresses_flat_edit',array(
                'id' => $object->getId()
            )),
                'security' => $this->get('security.context')
        ));
        
        $form->handleRequest($request);
        
        if ($form->isValid())
        {
            if ( false === $this->isZkGranded(array('ROLE_FLAT_WRITE')) )
            {
                throw new AccessDeniedException();
            }
            
            $em->flush();
            
            $notice = $this->get('translator')->trans('Your changes were saved');
            $this->get('session')->getFlashBag()->add('success', $notice);
                
            return $this->redirect( $this->generateUrl( 'crm_addresses_flat_edit',array(
                'id' => $object->getId()
            )));
        }
        
        return $this->render('CrmAddressesBundle:Flat:edit.html.twig', array(
            'form' => $form->createView(),
            'flat' => $object,
            
        ));
    }
    
    /**
     * newAction
     */
    public function newAction( Request $request, $parad_id)
    {
        if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_FLAT_ATTRIBUTE_WRITE')) )
        {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $parad = $em->getRepository('Crm\AddressesBundle\Entity\Parad')->find($parad_id);
        
        if( !$parad )
        {
            throw new NotFoundHttpException('Помилка! Під’їзд для прив’язки не знайдено!');
        }
      
        $object = new $this->class($parad);
        
        $form = $this->createForm( new FlatType($object), $object, array(
            'action' => $this->generateUrl('crm_addresses_flat_new',array(
                'parad_id' => $parad_id,
            )),
            'security' => $this->get('security.context')
        ));
          
        $form->handleRequest($request);
            
            if( $form->isValid() ) 
            {
                preg_match_all('/(\d+-\d+)|(\d+\/\d)|(\d+[a-zA-Zа-яА-я])|(\d+)/u', $object->getName(), $matches);
               
                foreach($matches[0] as $match)
                {
                    //условие если формат квартир вида 1-20
                    preg_match_all('/(\d+-\d+)/',$match,$diapazon);
                    if($diapazon and !empty($diapazon[1]))
                    {
                        $number =  explode("-", $match);
                        
                        for($i = $number[0];$i <= $number[1]; $i++)
                        {
                            $flat = $this->isValidFlat($parad,$object,$i);
                            
                            if(is_object( $flat))
                            {
                                $this->EntityManager()->persist($flat);
                            }
                            else
                            {
                                $this->get('session')->getFlashBag()->add('error',  $flat);
                                break(2);
                            }
                        }
                    }
                    //другой формат квартир 10,11,12а,12/3
                    else
                    {
                        if($match)
                        {
                            $flat = $this->isValidFlat($parad,$object,$match);
                            
                            if(is_object( $flat))
                            {
                                $this->EntityManager()->persist($flat);
                            }
                            else
                            {
                                $this->get('session')->getFlashBag()->add('error',  $flat);
                                break;
                            }
                        }
                    }
                }
                //если все квартиры уникальные для дома
                if(is_object( $flat))
                {
                    $this->EntityManager()->flush();
                    $notice = $this->get('translator')->trans('Your changes were saved');
                    $this->get('session')->getFlashBag()->add('success', $notice);
                    return $this->redirect( $this->generateUrl( 'crm_addresses_parad_edit',array(
                    'id' => $parad->getId()
                )));
                }
            }
         
        return $this->render('CrmAddressesBundle:Flat:edit.html.twig', array(
            'form' => $form->createView(),
            'flat' => $object,
            'parad' => $parad
        ));
    }

    
    /**
     * deleteAbonement
     */
    public function deleteAction( Request $request, $id )
    {
        if ( false === $this->isZkGranded(array('ROLE_ADDRESSES_FLAT_ATTRIBUTE_WRITE')) )
        {
            $error = $this->get('translator')->trans('You do not have enough privileges to carry out this action');
            $this->get('session')->getFlashBag()->add('error', $error);
        }
        else
        {
            $em = $this->getDoctrine()->getManager();
            $object = $em->getRepository($this->class)->find($id);
            if( !$object )
            {
                throw new NotFoundHttpException('Квартиру не знайдено!');
            }
            if( $object )
            {
                $log = $this->get('security.context')->getToken()->getUser()->getName().' :: '
                .$object->getStreetNameUa().", ".$object->getHouseName()." p". $object->getParadName()." k". $object->getName().' -> delete';
                $em->remove( $object );
                $em->flush();
                StaticFunctions::writeLog(
                    $this->get('kernel')->getRootDir().'/logs/deleteParadAction.log',
                    array($log)
                );
                $this->get('session')->getFlashBag()->add('success', 'Квартиру видалено');
            }
        }
        
        $referer = $request->headers->get('referer');      
        return new RedirectResponse($referer);
    }
    
     /**
     * isValidFlat
     */
    protected function isValidFlat($parad,$flat,$number)
    {
        if($parad->isUniqueFlat($number))
        {
            $flat = new $this->class($parad);
            
            $floor = $parad->findFlatFloor($number);
            $flat->setName($number);
            $flat->setFloor($floor);
            return $flat;
        }
        else
        {
            $note = 'Квартира '.$number.' вже є в цьому будинку!';
            return $note;
        }
    }
}
