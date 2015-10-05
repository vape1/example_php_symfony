<?php

namespace Zk\InterfaceBundle\AdminInterface;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Zk\InterfaceBundle\AdminInterface\Description\ListFieldDescription;
use Zk\InterfaceBundle\AdminInterface\Description\FilterFieldDescription;
use Zk\InterfaceBundle\AdminInterface\Form\Type\BuilderFormFilterType;

/**
 * @abstract class AdminInterfaceController
 * 
 * Generate admin's view
 * Class allows you to quickly generate administrativey interface to a tabular view "List",
 * broken down by pages, sorts and filters on all fields
 *
 * @since       1.0
 * @version     $Revision$
 */
abstract class AdminInterfaceController extends Controller
{
    /**
     * @var string $class (current class)
     */
    protected $class;
    
    /**
     * @var string $alias (current alias)
     */
    protected $alias;
    
    /**
     * @var \Doctrine\ORM\QueryBuilder
     */
    protected $query;
    
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;
    
    /**
     * @var \Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination
     */
    protected $paginator;
    
    /**
     * @var array $list_fields
     */
    protected $list_fields=array();
    
    /**
     * @var array $filter_fields
     */
    protected $filter_fields=array();

    /**
     * @var \Symfony\Component\Form\Form
     */
    protected $filter_form;

    /**
     * @var boolean $autosum
     */
    protected $autosum=false;

    /**
     * @var $em_name
     */
    protected $em_name='default';
    
    /**
     * @var \Zk\UserBundle\Entity\User
     */
    protected $total_user;
    
    
    /**
     * @var $user_view 
     */
    protected $user_view=array();
    
    /**
     * Constructor
     * 
     * @param string $class
     * @param string $alias
     */
    public function __construct( $class, $alias, $em_name='default' )
    {
        $this->class = $class;
        $this->alias = $alias;
        $this->em_name = $em_name;
    }
    
    /**
     * Get totalUser
     * 
     * @return \Zk\UserBundle\Entity\User
     */
    protected function getTotalUser()
    {
        if( !$this->total_user ) $this->createTotalUser();
        return $this->total_user;
    }
    
    /**
     * createTotalUser
     * 
     * @return \Zk\UserBundle\Entity\User
     */
    protected function createTotalUser()
    {
        $this->total_user = $this->get('security.context')->getToken()->getUser();
        return $this;
    }
    
    /**
     * Get current class
     * 
     * @return string current class name
     */
    protected function getClass()
    {
        return $this->class;
    }
    
    /**
     * Get EntityManager
     * 
     * @return EntityManager
     */
    protected function EntityManager()
    {
        return $this->em = $this->get('doctrine')->getManager( $this->em_name );
    }
    
    /**
     * Get EM (link Get EntityManager)
     * 
     * @return $this
     */
    protected function getEm()
    {
        if( !$this->em ) $this->em = $this->get('doctrine')->getManager( $this->em_name );
        return $this;
    }
    
    /**
     * buildQuery
     *
     * Building a query without conditions
     * 
     * @return $this
     */
    protected function isZkGranded( $roles )
    {
        if( !is_array( $roles ) ) $roles = array( $roles );
        if( $this->getTotalUser()->flagSuperAdmin() ) return true;
        return $this->get('security.context')->isGranted($roles);
    }
    
    /**
     * buildQuery
     *
     * Building a query without conditions
     * 
     * @return $this
     */
    protected function buildQuery()
    {
        $this->query =
        $this->em->getRepository($this->class)
        ->createQueryBuilder($this->alias);
        return $this;
    }
    
    /**
     * Get Query
     * 
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function getQuery()
    {
        if( !$this->query ) $this->buildQuery();
        return $this->query;
    }
    
    /**
     * Is Reset
     *
     * Check whether the event to reset all filters
     * If true - remove sessipn variable this filter
     * 
     * @return boolean
     */
    protected function isReset()
    {
        if($this->get('request')->query->get('_reset'))
        {
            $this->get('session')->remove( '_filter_'.$this->get('request')->get('_route') );
            $this->get('session')->remove( '_pager_'.$this->get('request')->get('_route') );
            return true;
        }
        return false;
    }

    /**
     * checkFilters
     * 
     * Build filters form
     * If the method POST filters are constructed and written to the session
     * else if in session is a form of filter-it is Otherwise,
     * if there is a default filters-they are  
     * 
     * @param array $default (stand default filter (option))
     * @return 
     */
    protected function checkFilters($default=array())
    {
        if( $this->filter_fields )
        {
            $this->filter_form = $this->createForm( new BuilderFormFilterType( $this->filter_fields ) );
            
            if( count($default) )
            {
                $this->filter_form->setData( $default );
            }
            
            if ( $this->get('request')->getMethod() == 'POST' )
            {
                $this->get('session')->remove( '_filter_'.$this->get('request')->get('_route') );
                $this->get('session')->remove( '_pager_'.$this->get('request')->get('_route') );
                
                $this->filter_form->bind( $this->get('request') );
                
                $this->get('zk_admin_interface.query_builder')->buildQuery( $this->filter_form, $this->query );
                
                $filterService = $this->get('zk_admin_interface.form_filter_session');
                $filterService->serialize( $this->filter_form->getData(),'_filter_'.$this->get('request')->get('_route') );
            }
            elseif( $this->get('session')->has( '_filter_'.$this->get('request')->get('_route') ) )
            {
                $filterService = $this->get('zk_admin_interface.form_filter_session');
                $data = $filterService->unserialize( '_filter_'.$this->get('request')->get('_route'), $this->em_name );
                
                $this->filter_form->setData( $data );
                $this->get('zk_admin_interface.query_builder')->buildQuery( $this->filter_form, $this->query );
            }
            elseif( count($default) )
            {
                $this->get('zk_admin_interface.query_builder')->buildQuery( $this->filter_form, $this->query );
            }
        }
    }

    /**
     * initAutosum
     * 
     * Initializs Autosum
     *
     * @see getSumColumns
     * 
     */
    protected function initAutosum()
    {
        $this->autosum = true;
    }

    /**
     * getSumColumns
     * 
     * The total sum of the values ​​for the selected columns
     * 
     * @return 
     */
    protected function getSumColumns()
    {
        if( $this->autosum )
        {
            $select = '';
            
            foreach( $this->list_fields as $field )
            {
                if( $field->getAutosum() )
                {
                    $select .=
                    sprintf("SUM(%s) AS %s,", $field->getPatternInAutosum(),$field->getAutosum());
                }
            }
            $select = trim($select,',');
            
            if( $select )
            {
                $q = strstr( $this->query->getQuery()->getDql(), " FROM " );
                $q = "SELECT ".$select.$q;
                
                $sumQuery = $this->em->createQuery($q)
                ->setParameters($this->query->getQuery()->getParameters())
                ->setMaxResults(1);
                
                try
                {
                    return $sumQuery->getSingleResult();
                }
                catch (\Doctrine\Orm\NoResultException $e)
                {
                    return null;
                }
            }
        }
        return null;
    }

    /**
     * getViewFiltersForm
     * 
     * @return \Symfony\Component\Form\Form::createView or false
     */
    protected function getViewFiltersForm()
    {
        if( $this->filter_fields )
        {
            return $this->filter_form->createView();
        }
        return false;
    }
    
    /**
     * Get Paginator
     * 
     * @param integer $limit ( limit per page )
     * @return \Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination
     */
    protected function getPaginator( $limit=30, $options=array() )
    {
        $page = 1;
        
        if( $this->get('request')->query->has('page') )
        {
            $page = $this->get('request')->query->get('page');
            $this->get('session')->set( '_pager_'.$this->get('request')->get('_route'), $page );
        }
        elseif( $this->get('session')->has( '_pager_'.$this->get('request')->get('_route') ) )
        {
            $page = $this->get('session')->get( '_pager_'.$this->get('request')->get('_route') );
        }
        
        $this->paginator = $this->get('knp_paginator');
        
        $pagination = $this->paginator->paginate(
            $this->query,
            $this->get('request')->query->get('page', $page), 
            $limit,
            $options
        );
        $pagination->setTemplate('ZkInterfaceBundle:AdminInterface:pagination.html.twig');
        $pagination->setSortableTemplate('ZkInterfaceBundle:AdminInterface:sortable.html.twig');

        return compact('pagination');
    }
    
    /**
     * addInList
     *
     * Method to add an array of items in the list
     *
     * @param array $field ( @see Zk\InterfaceBundle\AdminInterface\Description\ListFieldDescription )
     * @return $this
     */
    protected function addInList( array $field )
    {
        $this->list_fields[$field[2].'_'.$field[0]] = new ListFieldDescription( $field );
        return $this;
    }
    
    /**
     * addInFilter
     *
     * Method to add an array of items in the filter
     *
     * @param array $field ( @see Zk\InterfaceBundle\AdminInterface\Description\FilterFieldDescription )
     * @return $this
     */
    protected function addInFilter( array $field )
    {
        $this->filter_fields[$field[0]] = new FilterFieldDescription( $field );
        return $this;
    }
    /**
     * Get ListFields
     * 
     * @return array list_fields
     */
    public function getListFields()
    {
        return $this->list_fields;
    }
    
    /**
     * initUserView
     * 
     * @return array user_view
     */
    public function initUserView($type,$id=0)
    {
        $user_view = $this->getTotalUser()->getCurrentUserView($id);
        
        if($user_view and $user_view->getConfig())
        {
            $config = $user_view->getConfig();
            $this->user_view['list'] = $config['list'];
            $this->user_view['filter'] = $config['filter'];
        }
        else
        {
            $user_view = $this->container->getParameter('addresses_view');
            $this->user_view = $user_view[$type];
        }
        return $this->user_view;
    }
    
    /**
     * Get SortedListFields
     * 
     * @return array list_fields
     */
    public function getSortedListFields()
    {
        $res = array();
        foreach($this->user_view['list'] as $key)
        {
            if(key_exists($key,$this->list_fields))
            $res[] = $this->list_fields[$key];
        }
        
        if( $res ) $this->list_fields = $res;
    }

    /**
     * Get FilterFields
     * 
     * @return array filter_fields
     */
    public function getFilterFields()
    {
        return $this->filter_fields;
    }

    /**
     * Tranclation
     * 
     * @param string $word
     * @param string $domain
     * @param array $array
     *
     * @return string
     */
    protected function trans( $word, $domain='messages', $array=array() )
    {
        return $this->get('translator')->trans($word, $array, $domain);
    }
    
    /**
     * @abstract buildListFields
     *
     * @code
     * #name,label,alias,sort,func,filter,options,method,autosum
     *     ->addInList(array(
     *         'name',
     *         $this->trans('form.name','FOSUserBundle'),
     *         'u',
     *         true,
     *         null,
     *         null,
     *         array('link_id' => 'zk_admin_user_edit'),
     *         null,
     *         'all_cost' // alias
     *    ))
     * @endcode
     */
    abstract function buildListFields();
    
    /**
     * buildFilterFields
     *
     * @code
     * #name,type,label,count,condition_operator,options
     *     ->addInFilter(array(
     *         'u_name',
     *         'text_filter',
     *         $this->trans('form.name','FOSUserBundle'),
     *         5,
     *         'light_text'
     *    ))
     * @endcode
     */
    protected function buildFilterFields(){return;}
    
    /**
     * checkUserView
     *
     * Проверка настроек пользователя для отображения полей
     *
     * @param $field - поле
     * @param  $view  - вид(дом,подъезд, улица)
     * @param $type  - тип (list,filter) 
     * @return boolean
     */
    protected function checkUserView($field,$type)
    {
        if(in_array($field,$this->user_view[$type])) return true;
        return false;
    }
    

}
