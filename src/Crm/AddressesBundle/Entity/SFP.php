<?php

namespace Crm\AddressesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SFP
 *
 * @ORM\Table(name="address_sfp")
 * @ORM\Entity
 */
class SFP
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @ORM\Column(length=64)
     */
    protected $name;
    
    /**
     * @ORM\OneToMany(targetEntity="Crm\AddressesBundle\Entity\SwitchDevice", mappedBy="sfp", cascade={"persist"})
     */
    protected $switchDevices;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->switchDevices = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * toString
     */
    public function __toString()
    {
        return $this->name;
    }
    
    /**
     * Set name
     *
     * @param string $name
     * @return SFP
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
     * Add switchDevices
     *
     * @param \Crm\AddressesBundle\Entity\SwitchDevice $switchDevices
     * @return SFP
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
}