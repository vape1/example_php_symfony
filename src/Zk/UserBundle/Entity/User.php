<?php
namespace Zk\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Zk\UserBundle\Entity\Role;
use Zk\UserBundle\Entity\Group;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Zk\UserBundle\ZkUserBundle;

/**
 * @ORM\Entity(repositoryClass="Zk\UserBundle\Repository\UserRepository")		
 * @ORM\Table(name="fos_user")
 * @UniqueEntity("email")
 * @UniqueEntity("username")
 * 
 */
class User extends BaseUser //@Gedmo\Loggable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToMany(targetEntity="Zk\UserBundle\Entity\Role", cascade={"persist", "remove", "merge"})
     * @ORM\JoinTable(name="fos_user_role",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    protected $userRoles;
    
    /*
     * @var $preUserRoles
     * 
     * clone $userRoles
     */
    protected $preUserRoles;
    
    /**
     * @ORM\ManyToMany(targetEntity="Zk\UserBundle\Entity\Group", cascade={"persist", "remove", "merge"})
     * @ORM\JoinTable(name="fos_user_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    protected $userGroups;
    
    /**
     * @ORM\OneToMany(targetEntity="Zk\UserBundle\Entity\UserView", mappedBy="user", cascade={"persist"})
     */
    protected $userViews;
    
    /**
     * @ORM\OneToMany(targetEntity="Crm\AbonentBundle\Entity\Appl", mappedBy="user", cascade={"persist"})
     */
    protected $appl;

    /**
     * @ORM\OneToMany(targetEntity="Crm\AddressesBundle\Entity\SwitchDevice", mappedBy="installer", cascade={"persist"})
     */
    protected $switchDevices;
    
    /**
     * @ORM\OneToMany(targetEntity="Crm\AddressesBundle\Entity\Brand", mappedBy="installer", cascade={"persist"})
     */
    protected $brands;
    
    /**
     * @ORM\Column(length=64, nullable=true)
     */
    protected $name;
    
    /**
     * @ORM\Column(length=21, nullable=true)
     */
    protected $phone;

    /**
     * @ORM\Column(name="created_at",type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $sex;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $birthday;
    
    /**
     * @ORM\Column(length=255, nullable=true)
     */
    protected $descr;
    
    /**
     * @ORM\Column(name="super_admin",type="boolean")
     */
    protected $sAdmin;
    
    /**
     * @var $currentUser
     */
    protected $currentUser;
    
    
    /**
     * __construct
     *
     * @param string $name
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->username = uniqid("u", true);
        $this->userRoles = new ArrayCollection();
        $this->userGroups = new ArrayCollection();
        $this->enabled = false;
        $this->sAdmin = false;
    }
    
    /**
     * toString
     */
    public function __toString()
    {
        return $this->username;
    }
    
    /**
     * getCurrentUser
     *
     */
    public function getCurrentUser()
    {
        $container = ZkUserBundle::getContainer();
        $this->currentUser = $container->get('security.context')->getToken()->getUser();
    }
    
    /**
     * flagSuperAdmin
     *
     */
    public function flagSuperAdmin()
    {
        return $this->sAdmin;
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set phone
     *
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get sex
     *
     * @return integer
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set sex
     *
     * @param integer $sex
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
        return $this;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set descr
     *
     * @param string $descr
     */
    public function setDescr($descr)
    {
        $this->descr = $descr;
        return $this;
    }

    /**
     * Get descr
     *
     * @return string 
     */
    public function getDescr()
    {
        return $this->descr;
    }

    /**
     * Returns an ARRAY of Role objects with the default Role object appended.
     * @return array
     */
    public function getRoles()
    {
        $roles = $this->userRoles->toArray();

        foreach ($this->userGroups as $group) {
            $roles = array_merge( $roles, $group->getGroupRoles()->toArray() );
        }

        // we need to make sure to have at least one role
        $roles[] = new Role( parent::ROLE_DEFAULT );

        return array_unique($roles);
    }
    
    /**
     * Pass a string, get the desired Role object or null.
     * @param string $role
     * @return Role|null
     */
    public function getRole( $role )
    {
        foreach ( $this->userRoles as $roleItem )
        {
            if ( $role == $roleItem->getRole() )
            {
                return $roleItem;
            }
        }
        return null;
    }
    
    /**
     * Pass a string, checks if we have that Role. Same functionality as getRole() except returns a real boolean.
     * @param string $role
     * @return boolean
     */
    public function hasRole( $role )
    {
        if ( $this->getRole( $role ) )
        {
            return true;
        }
        return false;
    }

    /**
     * Adds a Role OBJECT to the ArrayCollection. Can't type hint due to interface so throws Exception.
     * @throws Exception
     * @param Role $role
     */
    public function addRole( $role )
    {
        if ( !$role instanceof Role )
        {
            throw new \Exception( "addRole takes a Role object as the parameter" );
        }
        
        if ( !$this->hasRole( $role->getRole() ) )
        {
            $this->userRoles->add( $role );
        }
    }
    
    /**
     * Clear user roles
     * 
     */
    public function clearUserRoles()
    {
        if( !$this->currentUser ) $this->getCurrentUser();
        
        foreach( $this->currentUser->getRoles() as $role )
        {
            $a = $this->userRoles->removeElement( $role );
        }
    }
    
    /**
     * Returns the true ArrayCollection of Roles.
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getPreUserRoles()
    {
        return $this->preUserRoles = clone $this->userRoles;
    }

    /**
     * Pass an ARRAY of Role objects and will clear the collection and re-set it with new Roles.
     * Type hinted array due to interface.
     * @param array $userRoles Of Role objects.
     */
    public function setPreUserRoles( $roles )
    {
        $this->clearUserRoles();
        foreach ( $roles as $role )
        {
            $this->addRole( $role );
        }
        return $this;
    }
    
    /**
     * Returns the true ArrayCollection of Roles.
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getUserRoles()
    {
        return $this->userRoles;
    }

    /**
     * Pass an ARRAY of Group objects and will clear the collection and re-set it with new Groups.
     * Type hinted array due to interface.
     * @param array $userGroups Of Group objects.
     */
    public function setGroups( array $groups )
    {
        $this->userGroups->clear();
        foreach ( $groups as $group )
        {
            $this->addGroup( $group );
        }
        return $this;
    }
    
    /**
     * Returns the true ArrayCollection of Groups.
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getUserGroups()
    {
        return $this->userGroups;
    }

    /**
     * Add userViews
     *
     * @param \Zk\UserBundle\Entity\UserView $userViews
     * @return User
     */
    public function addUserView(\Zk\UserBundle\Entity\UserView $userViews)
    {
        $this->userViews[] = $userViews;
    
        return $this;
    }

    /**
     * Remove userViews
     *
     * @param \Zk\UserBundle\Entity\UserView $userViews
     */
    public function removeUserView(\Zk\UserBundle\Entity\UserView $userViews)
    {
        $this->userViews->removeElement($userViews);
    }

    /**
     * Get userViews
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserViews()
    {
        return $this->userViews;
    }
    
    /**
     * Get userViewsByModule
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserViewsByModule($module)
    {
        return $this->getUserViews()->filter(function($brand) use($module){
            return $module === $brand->getModule(); 
        });
    }
    
    /**
     * Get CurrentUserView
     *
     * @return \Zk\UserBundle\Entity\UserView $userViews
     */
    public function getCurrentUserView($id)
    {   
        $views = $this->getUserViews();
        
        foreach($views as $view)
        {
            if($view->getId() == $id) return $view;
        }
        
        return false;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Set sAdmin
     *
     * @param boolean $sAdmin
     * @return User
     */
    public function setSAdmin($sAdmin)
    {
        $this->sAdmin = $sAdmin;
    
        return $this;
    }

    /**
     * Get sAdmin
     *
     * @return boolean 
     */
    public function getSAdmin()
    {
        return $this->sAdmin;
    }

    /**
     * Add userRoles
     *
     * @param \Zk\UserBundle\Entity\Role $userRoles
     * @return User
     */
    public function addUserRole(\Zk\UserBundle\Entity\Role $userRoles)
    {
        $this->userRoles[] = $userRoles;
    
        return $this;
    }

    /**
     * Remove userRoles
     *
     * @param \Zk\UserBundle\Entity\Role $userRoles
     */
    public function removeUserRole(\Zk\UserBundle\Entity\Role $userRoles)
    {
        $this->userRoles->removeElement($userRoles);
    }

    /**
     * Add userGroups
     *
     * @param \Zk\UserBundle\Entity\Group $userGroups
     * @return User
     */
    public function addUserGroup(\Zk\UserBundle\Entity\Group $userGroups)
    {
        $this->userGroups[] = $userGroups;
    
        return $this;
    }

    /**
     * Remove userGroups
     *
     * @param \Zk\UserBundle\Entity\Group $userGroups
     */
    public function removeUserGroup(\Zk\UserBundle\Entity\Group $userGroups)
    {
        $this->userGroups->removeElement($userGroups);
    }

    /**
     * Add switchDevices
     *
     * @param \Crm\AddressesBundle\Entity\SwitchDevice $switchDevices
     * @return User
     */
    public function addSwitchDevice(\Crm\AddressesBundle\Entity\SwitchDevice $switchDevices)
    {
        $this->switchDevices[] = $switchDevices;
    
        return $this;
    }

    /**
     * Remove switchDevices
     *
     * @param \Crm\AddressesBundle\Entity\SwitchDevice $switchDevices
     */
    public function removeSwitchDevice(\Crm\AddressesBundle\Entity\SwitchDevice $switchDevices)
    {
        $this->switchDevices->removeElement($switchDevices);
    }

    /**
     * Get switchDevices
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSwitchDevices()
    {
        return $this->switchDevices;
    }

    /**
     * Add brands
     *
     * @param \Crm\AddressesBundle\Entity\Brand $brands
     * @return User
     */
    public function addBrand(\Crm\AddressesBundle\Entity\Brand $brands)
    {
        $this->brands[] = $brands;
    
        return $this;
    }

    /**
     * Remove brands
     *
     * @param \Crm\AddressesBundle\Entity\Brand $brands
     */
    public function removeBrand(\Crm\AddressesBundle\Entity\Brand $brands)
    {
        $this->brands->removeElement($brands);
    }

    /**
     * Get brands
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBrands()
    {
        return $this->brands;
    }

    /**
     * Add appl
     *
     * @param \Crm\AbonentBundle\Entity\Appl $appl
     * @return User
     */
    public function addAppl(\Crm\AbonentBundle\Entity\Appl $appl)
    {
        $this->appl[] = $appl;
    
        return $this;
    }

    /**
     * Remove appl
     *
     * @param \Crm\AbonentBundle\Entity\Appl $appl
     */
    public function removeAppl(\Crm\AbonentBundle\Entity\Appl $appl)
    {
        $this->appl->removeElement($appl);
    }

    /**
     * Get appl
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAppl()
    {
        return $this->appl;
    }
}