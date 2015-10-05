<?php

namespace Zk\UserBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Zk\UserBundle\Entity\Role;

/**
 * @ORM\Entity(repositoryClass="Zk\UserBundle\Repository\GroupRepository")
 * @ORM\Table(name="fos_group")
 */
class Group extends BaseGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToMany(targetEntity="Zk\UserBundle\Entity\Role", cascade={"persist", "remove", "merge"})
     * @ORM\JoinTable(name="fos_group_role",
     *      joinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    protected $groupRoles;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $descr;

    /**                                                                                                                                                        
     * @Assert\True(message = "The name should match the pattern /^GROUP_[A-Z_0-9]{1,32}$/")                                                                    
     */ 
    public function isNameLegal()  
    {
        return preg_match("/^GROUP_[A-Z_0-9]{1,32}$/",$this->name);
    }
    
    /**
     * __construct
     *
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct($name);
        
        $this->groupRoles = new ArrayCollection();
    }
    
    public function __toString()
    {
        return $this->descr;
    }

    /**
     * Get groupRoles
     *
     * @return Doctrine\Common\Collections\ArrayCollection;
     */
    public function getGroupRoles()
    {
        return $this->groupRoles;
    }
    
    /**
     * Pass a string, get the desired Role object or null.
     * @param string $role
     * @return Role|null
     */
    public function getRole( $role )
    {
        foreach ( $this->groupRoles as $roleItem )
        {
            if ( $role == $roleItem->getRole() )
            {
                return $roleItem;
            }
        }
        return null;
    }
    
    /**
     * Pass a string, checks if we have that Role.
     * Same functionality as getRole() except returns a real boolean.
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
     * Adds a Role OBJECT to the ArrayCollection.
     * Can't type hint due to interface so throws Exception.
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
            $this->groupRoles->add( $role );
        }
    }
    
    /**
     * Pass an ARRAY of Role objects and will clear the collection and re-set it with new Roles.
     * Type hinted array due to interface.
     * @param array $userRoles Of Role objects.
     */
    public function setRoles( array $roles )
    {
        $this->groupRoles->clear();
        foreach ( $roles as $role )
        {
            $this->addRole( $role );
        }
    }
    
    /**
     * Returns an ARRAY of Role objects with the default Role object appended.
     * @return array
     */
    public function getRoles()
    {
        return $this->groupRoles->toArray();
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
     * Get full descr
     *
     * @return string 
     */
    public function getFullDescr()
    {
        $return = '';
        foreach( $this->groupRoles as $role )
        {
            $return .= sprintf("%s, ",$role->getName());
        }
        return trim($return, ', ');
    }
    
}
