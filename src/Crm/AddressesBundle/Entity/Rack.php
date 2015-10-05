<?php

namespace Crm\AddressesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Rack
 *
 * @ORM\Table(name="address_rack")
 * @ORM\Entity(repositoryClass="Crm\AddressesBundle\Repository\RackRepository")
 * @UniqueEntity("eprasysName")
 */
class Rack
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
     * @ORM\ManyToOne(targetEntity="Crm\AddressesBundle\Entity\Parad", inversedBy="racks")
     * @ORM\JoinColumn(name="parad_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $parad;
    
    /**
     * @ORM\OneToMany(targetEntity="Crm\AddressesBundle\Entity\SwitchDevice", mappedBy="rack", cascade={"persist"})
     */
    protected $switchDevices;
    
    /**
     * @ORM\Column(length=255,name="eprasys_name")
     */
    protected $eprasysName;
    
    /**
     * @ORM\Column(length=255,name="place_install")
     */
    protected $placeInstall;
    
    /**
     * @ORM\Column(name="date_install",type="datetime",nullable=true)
     */
    protected $dateInstall;
    
    /**
     * @ORM\Column(length=255,name="key_number")
     */
    protected $keyNumber;


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
    public function __construct(Parad $parad)
    {
        $this->switchDevices = new \Doctrine\Common\Collections\ArrayCollection();
        $this->parad = $parad;
    }
    
    /**
     * toString
     */
    public function __toString()
    {
        return $this->keyNumber;
    }
    
    /**
     * Set parad
     *
     * @param \Crm\AddressesBundle\Entity\Parad $parad
     * @return Rack
     */
    public function setParad(\Crm\AddressesBundle\Entity\Parad $parad = null)
    {
        $this->parad = $parad;
    
        return $this;
    }

    /**
     * Get parad
     *
     * @return \Crm\AddressesBundle\Entity\Parad 
     */
    public function getParad()
    {
        return $this->parad;
    }

    /**
     * Add switchDevices
     *
     * @param \Crm\AddressesBundle\Entity\SwitchDevice $switchDevices
     * @return Rack
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
     * Set eprasysName
     *
     * @param string $eprasysName
     * @return Rack
     */
    public function setEprasysName()
    {
        $paradEprasysName = $this->getParad()->getHouse()->getEprasysName();
        
        for($i=1;$i<1000;$i++)
        {
            $eName = 'R-'.$paradEprasysName.'-'.$i;
            $flag = 1;
            
            foreach($this->getParad()->getHouse()->getRacks() as $rack)
            {
                if($rack->getEprasysName() == $eName) $flag = 0;
            }
            if($flag)
            {
                $this->eprasysName = $eName;
                return $this;
            }
        }
    }
    

    /**
     * Set placeInstall
     *
     * @param string $placeInstall
     * @return Rack
     */
    public function setPlaceInstall($placeInstall)
    {
        $this->placeInstall = $placeInstall;
    
        return $this;
    }

    /**
     * Get placeInstall
     *
     * @return string 
     */
    public function getPlaceInstall()
    {
        return $this->placeInstall;
    }

    /**
     * Set dateInstall
     *
     * @param \DateTime $dateInstall
     * @return Rack
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
     * Set keyNumber
     *
     * @param string $keyNumber
     * @return Rack
     */
    public function setKeyNumber($keyNumber)
    {
        $this->keyNumber = $keyNumber;
    
        return $this;
    }

    /**
     * Get keyNumber
     *
     * @return string 
     */
    public function getKeyNumber()
    {
        return $this->keyNumber;
    }
    
    /**
     * Get keyNumberAndParad
     *
     * @return string 
     */
    public function getKeyNumberAndParad()
    {
        $result = $this->keyNumber. " п.".$this->getParadName();
        return $result;
    }
    
    /**
     * Get city
     *
     * @return string
     */
    public function getCityName()
    {
        $city = $this->getParad()->getCityName();
        return $city;
    }
    
    /**
     * Get street
     *
     * @return string 
     */
    public function getStreetNameUa()
    {
        $street =  $this->getParad()->getStreetNameRu();
        return $street;
    }
    
    /**
     * Get street
     *
     * @return string
     */
    public function getStreetNameRu()
    {
        $street =  $this->getParad()->getStreetNameUa();
        return $street;
    }
    
    /**
     * Get name
     *
     * @return string
     */
    public function getHouseName()
    {
        return $this->getParad()->getName();
    }
    
    /**
     * Get BilinkRegion
     *
     * @return string 
     */
    public function getBilinkRegion()
    {
        $bilinkRegion = $this->getParad()->getBilinkRegion();
        return  $bilinkRegion;
    }
    
    /**
     * Get Region
     *
     * @return string 
     */
    public function getRegion()
    {
        return  $this->getParad()->getRegion();
    }
    
    /**
     * Get subRegion
     *
     * @return string 
     */
    public function getSubRegion()
    {
        return  $this->getParad()->getSubRegion();
    }
    
    /**
     * Get name
     *
     * @return string 
     */
    public function getParadName()
    {
        return  $this->getParad()->getName();
    }
    
    /**
     * Get houseId
     *
     * @return string 
     */
    public function getHouseId()
    {
       return $this->getParad()->getHouseId();
    }
    
    /**
     * Get StreetId
     *
     * @return string 
     */
    public function getStreetId()
    {
       return $this->getParad()->getStreetId();
    }
    
    /**
     * Get RackId
     *
     * @return string 
     */
    public function getRackId()
    {
        return $this->id;
    }
    
     /**
     * Get ParadId
     *
     * @return integer
     */
    public function getParadId()
    {
        return  $this->getParad()->getId();
    }
    
    /**
     * Get faza2
     *
     * @return boolean
     */
    public function getFaza2()
    {
        return $this->getParad()->getFaza2();
    }
    
    /**
     * Get faza
     *
     * @return boolean
     */
    public function getFaza()
    {
        return $this->getParad()->getFaza();
    }
    
    /**
     * Get bilinkStoyak
     *
     * @return integer 
     */
    public function getBilinkStoyak()
    {
        return $this->getParad()->getBilinkStoyak();
    }
    
    /**
     * Get semafor
     *
     * @return integer 
     */
    public function getSemafor()
    {
        return $this->getParad()->getSemafor();
    }
    
    /**
     * Get eprasysNameParad
     *
     * @return string 
     */
    public function getEprasysNameParad()
    {
        return $this->getParad()->getEprasysName();
    }
    
    /**
     * Get eprasysNameRack
     *
     * @return string 
     */
    public function getEprasysName()
    {
        return $this->eprasysName;
    }
    
    /**
     * Get eprasysNameRack
     *
     * @return string 
     */
    public function getEprasysNameRack()
    {
        return $this->eprasysName;
    }
    
    /**
     * Get EprasysNameHouse
     *
     * @return string
     */
    public function getEprasysNameHouse()
    {
        return $this->getParad()->getEprasysNameHouse();
    }
    
    /**
     * Get accessParad
     *
     * @return boolean
     */
    public function getAccessParad()
    {
        return $this->getParad()->getAccessParad();
    }
    
    /**
     * Get commentAccessParad
     *
     * @return string 
     */
    public function getCommentAccessParad()
    {
        return  $this->getParad()->getCommentAccessParad();
    }
    
    /**
     * Get getAddressKey
     *
     * @return integer
     */
    public function getAddressKey()
    {
        return $this->getParad()->getAddressKey();
    }
    
    /**
     * Get planDateConn
     *
     * @return \DateTime 
     */
    public function getDateConn()
    {
        return $this->getParad()->getDateConn();
    }
    
    /**
     * hasChildren
     *
     * @return boolean
     */
    public function hasChildren()
    {
        if($this->getSwitchDevices()->count()) return true;
        return false;
    }
}