<?php

namespace Crm\AddressesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SwitchDeviceType
 *
 * @ORM\Table(name="address_switch_type")
 * @ORM\Entity
 */
class SwitchDeviceType
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
     * @ORM\Column(length=255,name="id_type")
     */
    protected $idType;

    /**
     * @ORM\Column(length=255,name="producer")
     */
    protected $producer;
    
    /**
     * @ORM\Column(type="integer",name="quant_ports")
     */
    protected $quantPorts;
    
    /**
     * @ORM\OneToMany(targetEntity="Crm\AddressesBundle\Entity\SwitchDevice", mappedBy="switchType", cascade={"persist"})
     */
    protected $switchDevices;

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
        return $this->idType;
    }
    
    /**
     * Set idType
     *
     * @param string $idType
     * @return SwitchDeviceType
     */
    public function setIdType($idType)
    {
        $this->idType = $idType;
    
        return $this;
    }

    /**
     * Get idType
     *
     * @return string 
     */
    public function getIdType()
    {
        return $this->idType;
    }

    /**
     * Set producer
     *
     * @param string $producer
     * @return SwitchDeviceType
     */
    public function setProducer($producer)
    {
        $this->producer = $producer;
    
        return $this;
    }

    /**
     * Get producer
     *
     * @return string 
     */
    public function getProducer()
    {
        return $this->producer;
    }

    /**
     * Set quantPorts
     *
     * @param integer $quantPorts
     * @return SwitchDeviceType
     */
    public function setQuantPorts($quantPorts)
    {
        $this->quantPorts = $quantPorts;
    
        return $this;
    }

    /**
     * Get quantPorts
     *
     * @return integer 
     */
    public function getQuantPorts()
    {
        return $this->quantPorts;
    }

    /**
     * Add switchDevices
     *
     * @param \Crm\AddressesBundle\Entity\SwitchDevice $switchDevices
     * @return SwitchDeviceType
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