<?php

namespace Crm\AddressesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Switch
 *
 * @ORM\Table(name="address_switch")
 * @ORM\Entity(repositoryClass="Crm\AddressesBundle\Repository\SwitchDeviceRepository")
 * @UniqueEntity("eprasysName")
 * @UniqueEntity("macAddress")
 * @UniqueEntity("serialNum")
 * 
 */
class SwitchDevice
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
     * @ORM\ManyToOne(targetEntity="Crm\AddressesBundle\Entity\Rack", inversedBy="switchDevices")
     * @ORM\JoinColumn(name="rack_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $rack;
    
    /**
     * @ORM\Column(length=255,name="eprasys_name")
     */
    protected $eprasysName;
    
    /**
     * @ORM\Column(name="date_install",type="datetime",nullable=true)
     */
    protected $dateInstall;
    
    /**
     * @ORM\ManyToOne(targetEntity="Crm\AddressesBundle\Entity\SwitchDeviceType", inversedBy="switchDevices")
     * @ORM\JoinColumn(name="switch_type_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $switchType;
    
    /**
     * @ORM\ManyToOne(targetEntity="Zk\UserBundle\Entity\User", inversedBy="switchDevices")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $installer;
    
    /**
     * @ORM\ManyToOne(targetEntity="Crm\AddressesBundle\Entity\Ring", inversedBy="switchDevices")
     * @ORM\JoinColumn(name="ring_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $ringNum;
    
    /**
     * @ORM\Column(type="boolean",name="on_control")
     */
    protected $onControl;
    
    /**
     * @ORM\Column(length=255,name="mac_address")
     */
    protected $macAddress;
    
    /**
     * @ORM\Column(length=255,name="serial_num")
     */
    protected $serialNum;
    
    /**
     * @ORM\Column(type="text",name="history",nullable=true)
     */
    protected $history;
    
    /**
     * @ORM\ManyToOne(targetEntity="Crm\AddressesBundle\Entity\SFP", inversedBy="switchDevices")
     * @ORM\JoinColumn(name="sfp_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $sfp;

    /**
     * Constructor
     */
    public function __construct(Rack $rack)
    {
        $this->rack = $rack;
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
     * Set rack
     *
     * @param \Crm\AddressesBundle\Entity\Rack $rack
     * @return SwitchDevice
     */
    public function setRack(\Crm\AddressesBundle\Entity\Rack $rack = null)
    {
        $this->rack = $rack;
    
        return $this;
    }

    /**
     * Get rack
     *
     * @return \Crm\AddressesBundle\Entity\Rack 
     */
    public function getRack()
    {
        return $this->rack;
    }

    
    /**
     * Get city
     *
     * @return string
     */
    public function getCityName()
    {
        $city = $this->getRack()->getCityName();
        return $city;
    }
    
    /**
     * Get street
     *
     * @return string 
     */
    public function getStreetNameUa()
    {
        $street =  $this->getRack()->getStreetNameRu();
        return $street;
    }
    
    /**
     * Get street
     *
     * @return string
     */
    public function getStreetNameRu()
    {
        $street =  $this->getRack()->getStreetNameUa();
        return $street;
    }
    
    /**
     * Get name
     *
     * @return string
     */
    public function getHouseName()
    {
        return $this->getRack()->getHouseName();
    }
    
    /**
     * Get EprasysNameHouse
     *
     * @return string
     */
    public function getEprasysNameHouse()
    {
        return $this->getRack()->getEprasysNameHouse();
    }
    
    /**
     * Get EprasysNameHouse
     *
     * @return string
     */
    public function getEprasysNameParad()
    {
        return $this->getRack()->getEprasysNameParad();
    }
    
    /**
     * Get EprasysNameHouse
     *
     * @return string
     */
    public function getEprasysNameRack()
    {
        return $this->getRack()->getEprasysName();
    }
    
    /**
     * Get BilinkRegion
     *
     * @return string 
     */
    public function getBilinkRegion()
    {
        $bilinkRegion = $this->getRack()->getBilinkRegion();
        return  $bilinkRegion;
    }
    
    /**
     * Get Region
     *
     * @return string 
     */
    public function getRegion()
    {
        return  $this->getRack()->getRegion();
    }
    
    /**
     * Get subRegion
     *
     * @return string 
     */
    public function getSubRegion()
    {
        return  $this->getRack()->getSubRegion();
    }
    
    /**
     * Get name
     *
     * @return string 
     */
    public function getParadName()
    {
        return  $this->getRack()->getParadName();
    }
    
    /**
     * Get parad
     *
     * @return \Crm\AddressesBundle\Entity\Parad 
     */
    public function getParad()
    {
        return $this->getRack()->getParad();
    }
    
    /**
     * Get houseId
     *
     * @return string 
     */
    public function getHouseId()
    {
       return $this->getRack()->getHouseId();
    }
    
    /**
     * Get StreetId
     *
     * @return string 
     */
    public function getStreetId()
    {
       return $this->getRack()->getStreetId();
    }
    
    /**
     * Get RackId
     *
     * @return string 
     */
    public function getRackId()
    {
        return $this->getRack()->getId();
    }
    
    /**
     * Get ParadId
     *
     * @return integer
     */
    public function getParadId()
    {
        return  $this->getRack()->getId();
    }
    
    /**
     * Get SwitchDeviceId
     *
     * @return integer
     */
    public function getSwitchDeviceId()
    {
        return  $this->getId();
    }
    
    /**
     * Get keyNumber
     *
     * @return string 
     */
    public function getKeyNumber()
    {
        return $this->getRack()->getKeyNumber();
    }
    
    /**
     * Get accessParad
     *
     * @return boolean
     */
    public function getAccessParad()
    {
        return $this->getRack()->getAccessParad();
    }
    
    /**
     * Get commentAccessParad
     *
     * @return string 
     */
    public function getCommentAccessParad()
    {
        return  $this->getRack()->getCommentAccessParad();
    }

    /**
     * Get getAddressKey
     *
     * @return integer
     */
    public function getAddressKey()
    {
        return $this->getRack()->getAddressKey();
    }
    
    /**
     * Get faza2
     *
     * @return boolean
     */
    public function getFaza2()
    {
        return $this->getRack()->getFaza2();
    }
    
    /**
     * Get faza
     *
     * @return boolean
     */
    public function getFaza()
    {
        return $this->getRack()->getFaza();
    }
    
    /**
     * Get bilinkStoyak
     *
     * @return integer 
     */
    public function getBilinkStoyak()
    {
        return $this->getRack()->getBilinkStoyak();
    }
    
    /**
     * Get semafor
     *
     * @return integer 
     */
    public function getSemafor()
    {
        return $this->getRack()->getSemafor();
    }
    
    /**
     * Get planDateConn
     *
     * @return \DateTime 
     */
    public function getDateConn()
    {
        return $this->getRack()->getDateConn();
    }
    
    /**
     * Set eprasysName SwitchDevice
     *
     * @param string $eprasysName SwitchDevice
     * @return SwitchDevice
     */
    public function setEprasysName()
    {
        $paradEprasysName = $this->getEprasysNameHouse();
        
        for($i=1;$i<1000;$i++)
        {
            $eName = 'S-'.$paradEprasysName.'-'.$i;
            $flag = 1;
            
            foreach($this->getRack()->getParad()->getHouse()->getSwitches() as $switch)
            {
                if($switch->getEprasysName() == $eName) $flag = 0;
            }
            
            if($flag)
            {
                $this->eprasysName = $eName;
                return $this;
            }
        }
    }

    /**
     * Get eprasysName
     *
     * @return string 
     */
    public function getEprasysName()
    {
        return $this->eprasysName;
    }

    /**
     * Set dateInstall
     *
     * @param \DateTime $dateInstall
     * @return SwitchDevice
     */
    public function setDateInstall($dateInstall)
    {
        $this->dateInstall = $dateInstall;
    
        return $this;
    }

    /**
     * Get dateInstall
     *
     * @return \DateTime 
     */
    public function getDateInstall()
    {
        return $this->dateInstall;
    }

    /**
     * Set onControl
     *
     * @param boolean $onControl
     * @return SwitchDevice
     */
    public function setOnControl($onControl)
    {
        $this->onControl = $onControl;
    
        return $this;
    }

    /**
     * Get onControl
     *
     * @return boolean 
     */
    public function getOnControl()
    {
        return $this->onControl;
    }

    /**
     * Set macAddress
     *
     * @param string $macAddress
     * @return SwitchDevice
     */
    public function setMacAddress($macAddress)
    {
        $this->macAddress = $macAddress;
    
        return $this;
    }

    /**
     * Get macAddress
     *
     * @return string 
     */
    public function getMacAddress()
    {
        return $this->macAddress;
    }

    /**
     * Set serialNum
     *
     * @param string $serialNum
     * @return SwitchDevice
     */
    public function setSerialNum($serialNum)
    {
        $this->serialNum = $serialNum;
    
        return $this;
    }

    /**
     * Get serialNum
     *
     * @return string 
     */
    public function getSerialNum()
    {
        return $this->serialNum;
    }

    /**
     * Set history
     *
     * @param string $history
     * @return SwitchDevice
     */
    public function setHistory($history)
    {
        $this->history = $history;
    
        return $this;
    }

    /**
     * Get history
     *
     * @return string 
     */
    public function getHistory()
    {
        return $this->history;
    }

    /**
     * Set switchType
     *
     * @param \Crm\AddressesBundle\Entity\SwitchType $switchType
     * @return SwitchDevice
     */
    public function setSwitchType(\Crm\AddressesBundle\Entity\SwitchDeviceType $switchType = null)
    {
        $this->switchType = $switchType;
    
        return $this;
    }

    /**
     * Get switchType
     *
     * @return \Crm\AddressesBundle\Entity\SwitchType 
     */
    public function getSwitchType()
    {
        return $this->switchType;
    }

    /**
     * Set installer
     *
     * @param \Zk\UserBundle\Entity\User $installer
     * @return SwitchDevice
     */
    public function setInstaller(\Zk\UserBundle\Entity\User $installer = null)
    {
        $this->installer = $installer;
    
        return $this;
    }

    /**
     * Get installer
     *
     * @return \Zk\UserBundle\Entity\User 
     */
    public function getInstaller()
    {
        return $this->installer;
    }

    /**
     * Set ringNum
     *
     * @param \Crm\AddressesBundle\Entity\Ring $ringNum
     * @return SwitchDevice
     */
    public function setRingNum(\Crm\AddressesBundle\Entity\Ring $ringNum = null)
    {
        $this->ringNum = $ringNum;
    
        return $this;
    }

    /**
     * Get ringNum
     *
     * @return \Crm\AddressesBundle\Entity\Ring 
     */
    public function getRingNum()
    {
        return $this->ringNum;
    }

    /**
     * Set sfp
     *
     * @param \Crm\AddressesBundle\Entity\SFP $sfp
     * @return SwitchDevice
     */
    public function setSfp(\Crm\AddressesBundle\Entity\SFP $sfp = null)
    {
        $this->sfp = $sfp;
    
        return $this;
    }

    /**
     * Get sfp
     *
     * @return \Crm\AddressesBundle\Entity\SFP 
     */
    public function getSfp()
    {
        return $this->sfp;
    }
}