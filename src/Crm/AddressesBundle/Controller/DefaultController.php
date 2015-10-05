<?php

namespace Crm\AddressesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
#use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Zk\InterfaceBundle\AdminInterface\AdminInterfaceController;

class DefaultController extends AdminInterfaceController
{
    /**
     * @param string $class
     */
    public function __construct()
    {
        parent::__construct('Crm\AddressesBundle\Entity\House','h');
    }
    
    public function indexAction()
    {
        
        if( $this->isReset() )
        {
            return $this->redirect( $this->generateUrl( $this->get('request')->get('_route') ) );
        }
        
        $this->buildListFields();
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
        
        return $this->render('CrmAddressesBundle::list.html.twig', array(
            'results'     => $pagination,
            'items'       => $items,
            'filter_form' => $filter_form,
            //'addon_options' => array( 'categories' => $this->getCategories() ),
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
            'city',
            $this->trans('city','address'),
            'c',
            true,
            null,
            null,
            array('style' => 'text-align:center'),
            
        ))
        ->addInList(array(
            'region',
            $this->trans('admR','address'),
            'h',
            true,
            null,
            null,
            array('style' => 'text-align:center'),
            
        ))
        ->addInList(array(
            'bilinkRegion',
            $this->trans('bilinkR','address'),
            'br',
            true,
            null,
            null,
            array('style' => 'text-align:center'),
        ))
        ->addInList(array(
            'subRegion',
            $this->trans('subR','address'),
            'sb',
            true,
            null,
            null,
            array('style' => 'text-align:center'),
        ))
        ->addInList(array(
            'eprasysName',
            $this->trans('eprasysHouse','address'),
            'h',
            true,
            null,
            null,
            array('style' => 'text-align:center')
        ))
        ->addInList(array(
            'street',
            $this->trans('street','address'),
            's',
            true,
            null,
            null,
            array('style' => 'text-align:center'),
            'getStreetFull'
        ))
        ->addInList(array(
            'name',
            $this->trans('numHouse','address'),
            'h',
            true,
            null,
            null,
            array('style' => 'text-align:center')
        ))
        //->addInList(array(
        //    'conditionHouse',
        //    $this->trans('street','address'),
        //    'h',
        //    true,
        //    null,
        //    null,
        //    array()
        //))
        ->addInList(array(
            'edit',
            $this->trans('edit','address'),
            null,
            false,
            null,
            null,
            array('class' => 'zeka_center')//'link_id' => 'rodina_crm_calls_edit'
        ))
        ;
    }
    
    /**
     * buildListFields
     * name,type,label,count,sort,condition_operator,options
     */
    public function buildFilterFields()
    {
        $this
        //->addInFilter(array(
        //    'g_moduleName',
        //    'entity_filter',
        //    $this->trans('content_group.name','portal'),
        //    2,
        //    'smal_int',
        //    array(
        //        'entity_type' => 'entity',
        //        'entity_class' => 'Rodina\CrmBundle\Entity\Portal\ContentGroup',
        //        'property' => 'moduleName'
        //    ),
        //))
        ->addInFilter(array(
            'h_region',
            'text_filter',
            $this->trans('num_dogovor','abonent'),
            5,
            'light_text'
        ))
        ->addInFilter(array(
            'sb_nameRu',
            'text_filter',
            'Email',
            5,
            'light_text'
        ))
        ->addInFilter(array(
            'h_street',
            'text_filter',
            $this->trans('num_dogovor','abonent'),
            5,
            'medium_int'
        ))
        //->addInFilter(array(
        //    'o_isActive',
        //    'boolean_filter',
        //    $this->trans('Public'),
        //))
        ;
    }
}
