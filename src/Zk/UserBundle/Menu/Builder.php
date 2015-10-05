<?php

namespace Zk\UserBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Security\Core\SecurityContext;

class Builder extends ContainerAware
{
    protected $factory;
    
    protected $user;
    
    protected $menu;
    
    protected $translator;
    
    protected $securityContext;
    
    protected $request;
    
    protected $options;
    
    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(
                                   Request $request,
                                   Translator $translator,
                                   SecurityContext $securityContext,
                                   array $options=array()
    )
    {
        $this->translator = $translator;
    
        $this->securityContext = $securityContext;
    
        $this->request = $request;
        
        $this->options = $options;
       
        $this->user = ( $this->securityContext->getToken()
                       and $this->securityContext->getToken()->getUser() instanceof \Zk\UserBundle\Entity\User )
        ? $this->securityContext->getToken()->getUser()
        : null;
        
        $this->menu = $this->factory->createItem('root'); 
        
        $item = $this->menu->setChildrenAttribute('class', 'pull-right');
        
        //$this->getAddressesMenu();
        //$this->getAbonentMenu();
        //
        //$this->getServiceMenu();
        //
        //$this->getContentMenu();
        //
        //$this->getStatisticMenu();
        //
        //$this->getMiddlewareMenu();
        //
        //$this->getSettingMenu();
        
        $this->getProfileMenu();
        //"<pre>";print_r($this->menu->getRoot()->toArray());echo"</pre>";exit;
        
        return $this->menu;
    }
    
    public function createDopMenu(
                                   Request $request,
                                   SecurityContext $securityContext,
                                   array $options=array()
    )
    {
        $this->securityContext = $securityContext;
    
        $this->request = $request;
        
        $this->options = $options;
       
        $this->user = ( $this->securityContext->getToken()
                       and $this->securityContext->getToken()->getUser() instanceof \Zk\UserBundle\Entity\User )
        ? $this->securityContext->getToken()->getUser()
        : null;
        
        $this->menu = $this->factory->createItem('root'); 
        
        $item = $this->menu->setChildrenAttribute('class', 'pull-left');
        
        $this->getAddressesMenu();
        $this->getAbonentMenu();
        //
        //$this->getServiceMenu();
        //
        //$this->getContentMenu();
        //
        //$this->getStatisticMenu();
        //
        //$this->getMiddlewareMenu();
        //
        //$this->getSettingMenu();
        
        //$this->getProfileMenu();
        //"<pre>";print_r($this->menu->getRoot()->toArray());echo"</pre>";exit;
        
        return $this->menu;
    }

    /**
     * isPerm
     */
    public function isPerm( array $perm )
    {
        return $this->user->flagSuperAdmin() or $this->securityContext->isGranted( $perm );
    }
    
    /**
     * addUserView
     */
    public function addUserView($obj_views,$address,$module)
    {
        $address->addChild($module.'_setting_d1', array('attributes' => array('divider' => true)));
            
            foreach($obj_views as $obj_view)
            {
                $address->addChild($module.'_list'.$obj_view->getId(), array(
                  'route' => 'crm_addresses_'.$module.'_list',
                  'routeParameters' => array('view_id' => $obj_view->getId())
                ))
                ->setLabel('.icon-submenu '.$obj_view->getName());
            }
            
        $address->addChild($module.'_setting_d2', array('attributes' => array('divider' => true)));
        
        return $address;
    }
    
    
    /**
     * Get menu "Abonent"
     */
    public function getAddressesMenu()
    {
        $address = $this->menu->addChild('addresses', array('uri' => '#'))
            ->setAttribute('class', 'dropdown')
            ->setLabel('.icon-home База Будинків');
            
        //House
        if( $this->isPerm(array('ROLE_ADDRESSES_HOUSE_ADDRESS_READ')))
        {
            $address->addChild('house_list', array(
                'route' => 'crm_addresses_house_list',
            ))
            ->setLabel('.icon-screenshot Будинки');
         
            if( $obj_views = $this->user->getUserViewsByModule('house') and $obj_views->count())
            {
                $this->addUserView($obj_views,$address,'house');
            }
        }
        
        
        //Parad
        if( $this->isPerm(array('ROLE_ADDRESSES_PARAD_ATTRIBUTE_READ')))
        {
            $address->addChild('parad_list', array(
                'route' => 'crm_addresses_parad_list',
            ))
            ->setLabel('.icon-screenshot Під’їзди');
         
            if( $obj_views = $this->user->getUserViewsByModule('parad') and $obj_views->count())
            {
                $this->addUserView($obj_views,$address,'parad');
            }
        }
        
        //Rack
        if( $this->isPerm(array('ROLE_ADDRESSES_RACK_READ')))
        {
            $address->addChild('rack_list', array(
                'route' => 'crm_addresses_rack_list',
            ))
            ->setLabel('.icon-screenshot Ящики');
         
            if( $obj_views = $this->user->getUserViewsByModule('rack') and $obj_views->count())
            {
                $this->addUserView($obj_views,$address,'rack');
            }
        }
        
        //SwitchDevice
        if( $this->isPerm(array('ROLE_ADDRESSES_RACK_READ')))
        {
            $address->addChild('switch_device_list', array(
                'route' => 'crm_addresses_switch_device_list',
            ))
            ->setLabel('.icon-screenshot Свічі');
         
            if( $obj_views = $this->user->getUserViewsByModule('switch_device') and $obj_views->count())
            {
                $this->addUserView($obj_views,$address,'switch_device');
            }
        }
        
        //Street
        $address->addChild('street_list', array(
            'route' => 'crm_addresses_street_list',
        ))
        ->setLabel('.icon-bell Вулиці');
        
        if( $obj_views = $this->user->getUserViewsByModule('street') and $obj_views->count())
        {
            $this->addUserView($obj_views,$address,'street');
        }
        
        $address->addChild('region_list', array(
            'route' => 'crm_addresses_region_list',
        ))
        ->setLabel('.icon-bell Адмін. район');
        
        $address->addChild('sub_region_list', array(
            'route' => 'crm_addresses_sub_region_list',
        ))
        ->setLabel('.icon-bell Під район');
        
        $address->addChild('sub_bilink_region_list', array(
            'route' => 'crm_addresses_bilink_region_list',
        ))
        ->setLabel('.icon-bell Район білінк');
        
        $address->addChild('city_list', array(
            'route' => 'crm_addresses_city_list',
        ))
        ->setLabel('.icon-bell Місто');
        
        $address->addChild('service_org_list', array(
            'route' => 'crm_addresses_service_org_list',
        ))
        ->setLabel('.icon-bell Обслуговуюча організація');
        
        //Flat
        if( $this->isPerm(array('ROLE_ADDRESSES_FLAT_ATTRIBUTE_READ')))
        {
            $address->addChild('flat_list', array(
                'route' => 'crm_addresses_flat_list',
            ))
            ->setLabel('.icon-bell Квартири');
         
            if( $obj_views = $this->user->getUserViewsByModule('flat') and $obj_views->count())
            {
                $this->addUserView($obj_views,$address,'flat');
            }
        }
        
        $address->addChild('ring', array(
            'route' => 'crm_addresses_ring_list',
        ))
        ->setLabel('.icon-bell Кільця');
        
        $address->addChild('switch_device_type', array(
            'route' => 'crm_addresses_switch_device_type_list',
        ))
        ->setLabel('.icon-bell Типи свічів');
        
        $address->addChild('rival', array(
            'route' => 'crm_addresses_rival_list',
        ))
        ->setLabel('.icon-bell Конкуренти');
        
        if( !$this->isPerm(array('ROLE_CALL_LIST')))
        {
            $address->getChild('calls_list')->setAttribute('class', 'disabled')->setUri('#');
        }

    }

    /**
     * Get menu "Profile"
     */
    public function getProfileMenu()
    {
        if( $this->user )
        {
            $profile = $this->menu->addChild('profile', array())
            ->setAttribute('class', 'dropdown')
            ->setLabel('.icon-user '.$this->user->getEmail());
            
            $profile->addChild('profile_show', array(
                'route' => 'fos_user_profile_show'
            ))
            ->setLabel('.icon-user '.$this->translator->trans('main.profile',array(),'sfMenu'));
            
            $profile->addChild('password_change', array(
                'route' => 'fos_user_change_password'
            ))
            ->setLabel('.icon-refresh '.$this->translator->trans('main.change_password',array(),'sfMenu'));
            
            $profile->addChild('profile_d1', array('attributes' => array('divider' => true)));
            
            $profile->addChild('zk_admin_user_list', array(
                'route' => 'zk_admin_user_list'
            ))
            ->setLabel('.icon-tasks '.$this->translator->trans('main.user_list',array(),'sfMenu'));
            if( !$this->isPerm(array('ROLE_USER_LIST')))
            {
                $profile->getChild('zk_admin_user_list')->setAttribute('class', 'disabled')->setUri('#');
            }
            
            $profile->addChild('zk_admin_role_list', array(
                'route' => 'zk_admin_role_list'
            ))
            ->setLabel('.icon-tasks '.$this->translator->trans('main.role_list',array(),'sfMenu'));
            if( !$this->isPerm(array('ROLE_ROLE_LIST')))
            {
                $profile->getChild('zk_admin_role_list')->setAttribute('class', 'disabled')->setUri('#');
            }
            
            $profile->addChild('zk_admin_group_list', array(
                'route' => 'zk_admin_group_list'
            ))
            ->setLabel('.icon-tasks '.$this->translator->trans('main.group_list',array(),'sfMenu'));
            if( !$this->isPerm(array('ROLE_GROUP_LIST')))
            {
                $profile->getChild('zk_admin_group_list')->setAttribute('class', 'disabled')->setUri('#');
            }
                
            $profile->addChild('profile_d2', array('attributes' => array('divider' => true)));
            
            $profile->addChild('logout', array(
                'route' => 'logout'
            ))
            ->setLabel('.icon-road '.$this->translator->trans('main.logout',array(),'sfMenu'));
        }
        else
        {
            $this->menu->addChild('login', array(
                'route' => 'login'
            ))
            ->setLabel('.icon-lock '.$this->translator->trans('main.login',array(),'sfMenu'));
        }
    }
    
    /**
     * Get menu "Select language"
     */
    public function getLangMenu()
    {
        if( !isset($this->options['locale']) or !$this->options['locale'] ) return;
      
        $lang = $this->menu->addChild('lang', array('uri' => '#'))
        ->setAttribute('class', 'dropdown')
        ->setLabel( '<img style="margin-top:-3px;" src="/img/lang_'.strtolower($this->request->getLocale()).'_min.png"> '.strtoupper($this->request->getLocale()) );
        
        $lang->addChild('en_locale', array(
            'route' => 'zk_set_locale',
            'routeParameters' => array('locale' => 'en')
        ))
        ->setLabel('<img src="/img/lang_en_min.png"> English');
        
        $lang->addChild('ru_locale', array(
            'route' => 'zk_set_locale',
            'routeParameters' => array('locale' => 'ru')
        ))
        ->setLabel('<img src="/img/lang_ru_min.png">  Русский');
    }

    /**
     * Get menu "Setting"
     */
    public function getSettingMenu()
    {
        $setting = $this->menu->addChild('setting', array('uri' => '#'))
            ->setAttribute('class', 'dropdown')
            ->setLabel('.icon-wrench Настройки');
            
        $setting->addChild('currency', array(
            'route' => 'admin_currency_list',
        ))
        ->setLabel('.icon-signal Курсы валют');
        if( !$this->isPerm(array('ROLE_CURRENCY_LIST')))
        {
            $setting->getChild('currency')->setAttribute('class', 'disabled')->setUri('#');
        }
        
        $setting->addChild('paysystem_list', array(
            'route' => 'rodina_payment_paysystem_list',
        ))
        ->setLabel('.icon-download-alt Платёжные системы');
        if( !$this->isPerm(array('ROLE_PAYSYSTEM_LIST')))
        {
            $setting->getChild('paysystem_list')->setAttribute('class', 'disabled')->setUri('#');
        }
        
        $setting->addChild('black_list', array(
            'route' => 'admin_black_list',
        ))
        ->setLabel('.icon-ban-circle Black list');
        if( !$this->isPerm(array('ROLE_BLACK_LIST_SHOW')))
        {
            $setting->getChild('black_list')->setAttribute('class', 'disabled')->setUri('#');
        }
        
        $setting->addChild('vms_list', array(
            'route' => 'crm_vms_list',
        ))
        ->setLabel('.icon-hdd VMS');
        if( !$this->isPerm(array('ROLE_VMS_VIEW')))
        {
            $setting->getChild('vms_list')->setAttribute('class', 'disabled')->setUri('#');
        }
    }

    /**
     * Get menu "Middleware"
     */
    public function getMiddlewareMenu()
    {
        $setting = $this->menu->addChild('middleware', array('uri' => '#'))
            ->setAttribute('class', 'dropdown')
            ->setLabel('.icon-forward Middleware');
            
        $setting->addChild('monitoring_list', array(
            'route' => 'ott_core_monitoring',
        ))
        ->setLabel('.icon-play Мониторинг');
        if( !$this->isPerm(array('ROLE_OTTCORE_MONITORING')))
        {
            $setting->getChild('monitoring_list')->setAttribute('class', 'disabled')->setUri('#');
        }
        
        $setting->addChild('channel_list', array(
            'route' => 'ott_core_channel_list',
        ))
        ->setLabel('.icon-play Каналы');
        if( !$this->isPerm(array('ROLE_OTTCORE_CHANNEL_LIST')))
        {
            $setting->getChild('channel_list')->setAttribute('class', 'disabled')->setUri('#');
        }
        
        $setting->addChild('mcas_listt', array(
            'route' => 'ott_core_mcast_list',
        ))
        ->setLabel('.icon-play Мультикасты');
        if( !$this->isPerm(array('ROLE_OTTCORE_MCAST_LIST')))
        {
            $setting->getChild('mcas_listt')->setAttribute('class', 'disabled')->setUri('#');
        }
        
        $setting->addChild('category_list', array(
            'route' => 'ott_core_category_list',
        ))
        ->setLabel('.icon-play Категории');
        if( !$this->isPerm(array('ROLE_OTTCORE_CATEGORY_LIST')))
        {
            $setting->getChild('category_list')->setAttribute('class', 'disabled')->setUri('#');
        }
        
        $setting->addChild('rserver_list', array(
            'route' => 'ott_core_rserver_list',
        ))
        ->setLabel('.icon-play Сервера');
        if( !$this->isPerm(array('ROLE_OTTCORE_RSERVER_LIST')))
        {
            $setting->getChild('rserver_list')->setAttribute('class', 'disabled')->setUri('#');
        }
        
        $setting->addChild('rserver_group_list', array(
            'route' => 'ott_core_rserver_group_list',
        ))
        ->setLabel('.icon-play Пулы серверов');
        if( !$this->isPerm(array('ROLE_OTTCORE_RSERVER_LIST')))
        {
            $setting->getChild('rserver_group_list')->setAttribute('class', 'disabled')->setUri('#');
        }
    }

    /**
     * Get menu "Statistic"
     */
    public function getStatisticMenu()
    {
        $setting = $this->menu->addChild('stat', array('uri' => '#'))
            ->setAttribute('class', 'dropdown')
            ->setLabel('.icon-time Отчёты');
            
        $setting->addChild('statistic_pay', array(
            'route' => 'rodina_statistic_pay',
        ))
        ->setLabel('.icon-star Отчет "Поступление денег"');
        if( !$this->isPerm(array('ROLE_STATISTIC_PAY')))
        {
            $setting->getChild('statistic_pay')->setAttribute('class', 'disabled')->setUri('#');
        }
            
        $setting->addChild('correction', array(
            'route' => 'rodina_statistic_correction',
        ))
        ->setLabel('.icon-circle-arrow-up Отчет "Корректоровки / Ожидание оплаты"');
        if( !$this->isPerm(array('ROLE_STATISTIC_CORRECTION')))
        {
            $setting->getChild('correction')->setAttribute('class', 'disabled')->setUri('#');
        }
            
        $setting->addChild('payment_change', array(
            'route' => 'rodina_statistic_payment_change',
        ))
        ->setLabel('.icon-asterisk Отчет "История изменения платежей"');
        if( !$this->isPerm(array('ROLE_STATISTIC_HISTORY_CHANGE_PAY')))
        {
            $setting->getChild('payment_change')->setAttribute('class', 'disabled')->setUri('#');
        }
            
        $setting->addChild('comeback_money', array(
            'route' => 'rodina_statistic_comeback_money',
        ))
        ->setLabel('.icon-share-alt Отчет "Возвраты"');
        if( !$this->isPerm(array('ROLE_STATISTIC_COMEBACK_MONEY')))
        {
            $setting->getChild('comeback_money')->setAttribute('class', 'disabled')->setUri('#');
        }
            
        $setting->addChild('shipping', array(
            'route' => 'rodina_statistic_shipping',
        ))
        ->setLabel('.icon-flag Отчет "Доставка"');
        if( !$this->isPerm(array('ROLE_STATISTIC_SHIPPING')))
        {
            $setting->getChild('shipping')->setAttribute('class', 'disabled')->setUri('#');
        }
        
        $setting->addChild('setting_d1', array('attributes' => array('divider' => true)));
            
        $setting->addChild('online_tv', array(
            'route' => 'rodina_statistic_online_tv_stat',
        ))
        ->setLabel('.icon-eye-open Отчет "Онлайн просмотры"');
        if( !$this->isPerm(array('ROLE_STATISTIC_ONLINE_TV')))
        {
            $setting->getChild('online_tv')->setAttribute('class', 'disabled')->setUri('#');
        }
        
        $setting->addChild('rating', array(
            'route' => 'rodina_statistic_rating',
        ))
        ->setLabel('.icon-thumbs-up Отчет "Рейтинг каналов"');
        if( !$this->isPerm(array('ROLE_STATISTIC_RATING')))
        {
            $setting->getChild('rating')->setAttribute('class', 'disabled')->setUri('#');
        }
        
        $setting->addChild('setting_d2', array('attributes' => array('divider' => true)));
        
        $setting->addChild('diller_bonuce', array(
            'route' => 'rodina_statistic_diller_bonuce',
        ))
        ->setLabel('.icon-signal Отчет "Рейтинг дилеров"');
        if( !$this->isPerm(array('ROLE_STATISTIC_DILLERS')))
        {
            $setting->getChild('diller_bonuce')->setAttribute('class', 'disabled')->setUri('#');
        }
        
        $setting->addChild('setting_d3', array('attributes' => array('divider' => true)));
        
        $setting->addChild('stability_indicator', array(
            'route' => 'rodina_statistic_stability_indicator',
        ))
        ->setLabel('.icon-plus Отчет "Показатель стабильности"');
        if( !$this->isPerm(array('ROLE_STABILITY_INDICATOR')))
        {
            $setting->getChild('stability_indicator')->setAttribute('class', 'disabled')->setUri('#');
        }
        
        $setting->addChild('stability_indicator_off_days', array(
            'route' => 'rodina_statistic_stability_indicator_off_days',
        ))
        ->setLabel('.icon-resize-small Показатель стабильности - без учета');
        if( !$this->isPerm(array('ROLE_STABILITY_INDICATOR')))
        {
            $setting->getChild('stability_indicator_off_days')->setAttribute('class', 'disabled')->setUri('#');
        }
        
        $setting->addChild('setting_d4', array('attributes' => array('divider' => true)));
        
        $setting->addChild('statistic_abonents', array(
            'route' => 'rodina_statistic_abonents',
        ))
        ->setLabel('.icon-resize-small Отчет "Абоненты и абонементы"');
        if( !$this->isPerm(array('ROLE_STATISTIC_ABONENTS_AND_ABONEMENT')))
        {
            $setting->getChild('statistic_abonents')->setAttribute('class', 'disabled')->setUri('#');
        }
        
    } 

    /**
     * Get menu "Abonent"
     */
    public function getAbonentMenu()
    {
        $abonent = $this->menu->addChild('abonent', array('uri' => '#'))
            ->setAttribute('class', 'dropdown')
            ->setLabel('.icon-star Абоненти');
            
        $abonent->addChild('baseabonent', array(
            'route' => 'baseabonent',
        ))
        ->setLabel('.icon-screenshot Головна');
        
        $abonent->addChild('abonentph_list', array(
            'route' => 'abonentph',
        ))
        ->setLabel('.icon-screenshot Абоненти FTTB');
        
        //if( !$this->isPerm(array('ROLE_ABONENT_LIST')))
        //{
        //    $abonent->getChild('abonent_list')->setAttribute('class', 'disabled')->setUri('#');
        //}
        //
        //$abonent->addChild('calls_list', array(
        //    'route' => 'rodina_crm_calls_list',
        //))
        //->setLabel('.icon-bell Обращения');
        //if( !$this->isPerm(array('ROLE_CALL_LIST')))
        //{
        //    $abonent->getChild('calls_list')->setAttribute('class', 'disabled')->setUri('#');
        //}

    }

    /**
     * Get menu "Service"
     */
    public function getServiceMenu()
    {
        $service = $this->menu->addChild('service', array('uri' => '#'))
            ->setAttribute('class', 'dropdown')
            ->setLabel('.icon-certificate Услуги');
            
        $service->addChild('special_offer_list', array(
            'route' => 'rodina_crm_special_offer_list',
        ))
        ->setLabel('.icon-gift Предложения к продаже');
        if( !$this->isPerm(array('ROLE_SPECIAL_OFFER_LIST')))
        {
            $service->getChild('special_offer_list')->setAttribute('class', 'disabled')->setUri('#');
        }
        
        $service->addChild('special_offer_group_list', array(
            'route' => 'rodina_crm_special_offer_group_list',
        ))
        ->setLabel('.icon-tasks Группы предложений к продаже');
        if( !$this->isPerm(array('ROLE_SPECIAL_OFFER_GROUP_LIST')))
        {
            $service->getChild('special_offer_group_list')->setAttribute('class', 'disabled')->setUri('#');
        }
        
        $service->addChild('order_unit_list', array(
            'route' => 'rodina_crm_order_unit_list',
        ))
        ->setLabel('.icon-plus-sign Единицы заказа');
        if( !$this->isPerm(array('ROLE_ORDER_UNIT_LIST')))
        {
            $service->getChild('order_unit_list')->setAttribute('class', 'disabled')->setUri('#');
        }
        
        $service->addChild('service_d1', array('attributes' => array('divider' => true)));
        
        $service->addChild('service_list', array(
            'route' => 'rodina_crm_service_list',
        ))
        ->setLabel('.icon-certificate Доп. Услуги');
        if( !$this->isPerm(array('ROLE_SERVICE_LIST')))
        {
            $service->getChild('service_list')->setAttribute('class', 'disabled')->setUri('#');
        }
        
        $service->addChild('special_offer_service_list', array(
            'route' => 'rodina_crm_special_offer_service_list',
        ))
        ->setLabel('.icon-tasks Предложения к продаже Доп. Услуг');
        if( !$this->isPerm(array('ROLE_SPECIAL_OFFER_SERVICE_LIST')))
        {
            $service->getChild('special_offer_service_list')->setAttribute('class', 'disabled')->setUri('#');
        }
        
        $service->addChild('service_d2', array('attributes' => array('divider' => true)));
            
        $service->addChild('package_list', array(
            'route' => 'rodina_crm_package_list',
        ))
        ->setLabel('.icon-plus-sign Пакеты');
        if( !$this->isPerm(array('ROLE_PACKAGE_LIST')))
        {
            $service->getChild('package_list')->setAttribute('class', 'disabled')->setUri('#');
        }
            
        $service->addChild('tarif_list', array(
            'route' => 'rodina_crm_tarif_list',
        ))
        ->setLabel('.icon-download-alt Тарифы');
        if( !$this->isPerm(array('ROLE_TARIF_LIST')))
        {
            $service->getChild('tarif_list')->setAttribute('class', 'disabled')->setUri('#');
        }
            
        $service->addChild('product_list', array(
            'route' => 'rodina_crm_product_list',
        ))
        ->setLabel('.icon-bullhorn Товары');
        if( !$this->isPerm(array('ROLE_PRODUCT_LIST')))
        {
            $service->getChild('product_list')->setAttribute('class', 'disabled')->setUri('#');
        }
        
    }

    /**
     * Get menu "Content"
     */
    public function getContentMenu()
    {
        $content = $this->menu->addChild('content', array('uri' => '#'))
            ->setAttribute('class', 'dropdown')
            ->setLabel('.icon-picture Контент');
            
        $content->addChild('content_list', array(
            'route' => 'rodina_crm_portal_content_list',
        ))
        ->setLabel('.icon-picture Контент');
        if( !$this->isPerm(array('ROLE_CONTENT_LIST')))
        {
            $content->getChild('content_list')->setAttribute('class', 'disabled')->setUri('#');
        }
            
        $content->addChild('content_group_list', array(
            'route' => 'rodina_crm_portal_content_group_list',
        ))
        ->setLabel('.icon-eject Группы Контента');
        if( !$this->isPerm(array('ROLE_CONTENT_GROUP_LIST')))
        {
            $content->getChild('content_group_list')->setAttribute('class', 'disabled')->setUri('#');
        }
            
        $content->addChild('wiki_list', array(
            'route' => 'rodina_crm_portal_wiki_list',
        ))
        ->setLabel('.icon-question-sign База знаний');
        if( !$this->isPerm(array('ROLE_WIKI_LIST')))
        {
            $content->getChild('wiki_list')->setAttribute('class', 'disabled')->setUri('#');
        }
        
        $content->addChild('content_d1', array('attributes' => array('divider' => true)));
        
        $content->addChild('banner_list', array(
            'route' => 'rodina_crm_portal_banner_list',
        ))
        ->setLabel('.icon-adjust Баннеры');
        if( !$this->isPerm(array('ROLE_BANNER_LIST')))
        {
            $content->getChild('banner_list')->setAttribute('class', 'disabled')->setUri('#');
        }

        $content->addChild('slider_list', array(
            'route' => 'rodina_crm_portal_slider_list',
        ))
        ->setLabel('.icon-facetime-video Слайдеры');
        if( !$this->isPerm(array('ROLE_SLIDER_LIST')))
        {
            $content->getChild('slider_list')->setAttribute('class', 'disabled')->setUri('#');
        }
    }

}