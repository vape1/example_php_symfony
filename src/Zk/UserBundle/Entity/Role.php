<?php

namespace Zk\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * @ORM\Entity(repositoryClass="Zk\UserBundle\Repository\RoleRepository")
 * @ORM\Table( name="fos_role" )
 */
class Role implements RoleInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", unique=true, length=70)
     */
    protected $role;

    /**
     * @ORM\Column(type="string", length=70)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $descr;

    /**                                                                                                                                                        
     * @Assert\True(message = "The name should match the pattern /^ROLE_[A-Z_0-9]{1,32}$/")                                                                    
     */ 
    public function isRoleLegal()  
    {
        return preg_match("/^ROLE_[A-Z_0-9]{1,32}$/",$this->role);
    }
    
    /**
     * Populate the role field
     * @param string $role ROLE_FOO etc
     */
    public function __construct( $role )
    {
        $this->role = $role;
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
     * Return the role field.
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set role
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    /**
     * Return the name field.
     * @return string
     */
    public function __toString()
    {
        return (string) $this->name;
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
    
}

