<?php

namespace Crm\AbonentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reason
 *
 * @ORM\Table(name="abonent_appl_reason")
 * @ORM\Entity
 */
class Reason
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\OneToMany(targetEntity="Crm\AbonentBundle\Entity\Appl", mappedBy="reason", cascade={"persist"})
     */
    protected $appl;
    
    /**
     * @ORM\Column(length=255,name="name")
     */
    protected $name;
    
    /**
     * @ORM\Column(type="boolean",name="active")
     */
    protected $active;
    
    /**
     * @ORM\Column(length=255,name="descr",nullable=true)
     */
    protected $descr;
    
    /**
     * __toString
     */
    public function __toString()
    {
        return $this->getName();
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
       
        $this->active = false;
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
     * @return Reason
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
     * Set active
     *
     * @param boolean $active
     * @return Reason
     */
    public function setActive($active)
    {
        $this->active = $active;
    
        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set descr
     *
     * @param string $descr
     * @return Reason
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
     * Add appl
     *
     * @param \Crm\AbonentBundle\Entity\Appl $appl
     * @return Reason
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