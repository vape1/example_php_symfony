<?php

namespace Crm\AddressesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Crm\AddressesBundle\CrmAddressesBundle;
use Doctrine\ORM\Mapping\OrderBy;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * House
 *
 * @ORM\Table(name="address_house")
 * @ORM\Entity(repositoryClass="Crm\AddressesBundle\Repository\HouseRepository")
 * @UniqueEntity("eprasysName")
 * 
 */
class House
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
   # options={"comment" = "The string to show in the dropdown "}
    
    /**
     * @ORM\ManyToOne(targetEntity="Crm\AddressesBundle\Entity\Region", inversedBy="houses")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $region;
    
    /**
     * @ORM\ManyToOne(targetEntity="Crm\AddressesBundle\Entity\SubRegion", inversedBy="houses")
     * @ORM\JoinColumn(name="sub_region_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $subRegion;
    
    /**
     * @ORM\ManyToOne(targetEntity="Crm\AddressesBundle\Entity\Street", inversedBy="houses")
     * @ORM\JoinColumn(name="street_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $street;
    
    /**
     * @ORM\OneToMany(targetEntity="Crm\AddressesBundle\Entity\Parad", mappedBy="house", cascade={"persist"})
     * @OrderBy({"eprasysName" = "ASC"})
     */
    protected $parads;
    
    /**
     * @ORM\ManyToOne(targetEntity="Crm\AddressesBundle\Entity\HouseType", inversedBy="houses")
     * @ORM\JoinColumn(name="house_type_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $houseType;
    
    /**
     * @ORM\Column(length=255,name="eprasys_name")
     */
    protected $eprasysName;
    
    /**
     * @ORM\Column(length=255,name="name")
     */
    protected $name;
    
    
    /**
     * @ORM\Column(type="text",name="descr", nullable=true)
     */
    protected $descr;
    
    /**
     * @ORM\Column(type="integer",name="pay_port", nullable=true)
     */
    protected $payPort;
    
    /**
     * @ORM\Column(type="boolean",name="faza2")
     */
    protected $faza2;
    
    /**
     * @ORM\Column(type="boolean",name="optika_kan")
     */
    protected $optika_kan;
    
    /**
     * @ORM\Column(type="boolean",name="optika_air")
     */
    protected $optika_air;
    
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
        $this->parads = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * toString
     */
    public function __toString()
    {
        return $this->name;
    }
    
    /**
     * Set eprasysName
     *
     * @param string $eprasysName
     * @return House
     */
    public function setEprasysName($eprasysName)
    {
        $this->eprasysName = $eprasysName;
    
        return $this;
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
     * Set name
     *
     * @param string $name
     * @return House
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
     * Set region
     *
     * @param \Crm\AddressesBundle\Entity\Region $region
     * @return House
     */
    public function setRegion(\Crm\AddressesBundle\Entity\Region $region = null)
    {
        $this->region = $region;
    
        return $this;
    }

    /**
     * Get region
     *
     * @return \Crm\AddressesBundle\Entity\Region 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set subRegion
     *
     * @param \Crm\AddressesBundle\Entity\SubRegion $subRegion
     * @return House
     */
    public function setSubRegion(\Crm\AddressesBundle\Entity\SubRegion $subRegion = null)
    {
        $this->subRegion = $subRegion;
    
        return $this;
    }

    /**
     * Get subRegion
     *
     * @return \Crm\AddressesBundle\Entity\SubRegion 
     */
    public function getSubRegion()
    {
        return $this->subRegion;
    }

    /**
     * Set street
     *
     * @param \Crm\AddressesBundle\Entity\Street $street
     * @return House
     */
    public function setStreet(\Crm\AddressesBundle\Entity\Street $street = null)
    {
        $this->street = $street;
    
        return $this;
    }

    /**
     * Get street
     *
     * @return \Crm\AddressesBundle\Entity\Street 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Add parads
     *
     * @param \Crm\AddressesBundle\Entity\Parad $parads
     * @return House
     */
    public function addParad(\Crm\AddressesBundle\Entity\Parad $parads)
    {
        $this->parads[] = $parads;
    
        return $this;
    }

    /**
     * Remove parads
     *
     * @param \Crm\AddressesBundle\Entity\Parad $parads
     */
    public function removeParad(\Crm\AddressesBundle\Entity\Parad $parads)
    {
        $this->parads->removeElement($parads);
    }

    /**
     * Get parads
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getParads()
    {
        return $this->parads;
    }

    
    /**
     * Get city
     *
     * @return string
     */
    public function getCityName()
    {
        $city = $this->getRegion()->getCity()->getNameUa();
        return $city;
    }
    
    /**
     * Get street
     *
     * @return string
     */
    public function getStreetNameUa()
    {
        $street =  $this->getStreet()->getStreetNameUa();
        return $street;
    }
    
    /**
     * Get street
     *
     * @return string
     */
    public function getStreetNameRu()
    {
        $street =  $this->getStreet()->getStreetNameRu();
        return $street;
    }
    
     /**
     * Get name
     *
     * @return string
     */
    public function getHouseName()
    {
        return $this->name;
    }
    
     /**
     * Get EprasysNameHouse
     *
     * @return string
     */
    public function getEprasysNameHouse()
    {
        return $this->eprasysName;
    }
    
    /**
     * Get BilinkRegion
     *
     * @return string 
     */
    public function getBilinkRegion()
    {
        $bilinkRegion = $this->getSubRegion()->getBilinkRegion();
        return  $bilinkRegion;
    }
    
    /**
     * Get HouseId
     *
     * @return integer
     */
    public function getHouseId()
    {
        
        return $this->getId();
    }
    
    /**
     * Get StreetId
     *
     * @return integer
     */
    public function getStreetId()
    {
        $street = $this->getStreet()->getId();
        return  $street;
    }
    
    public function getEdit()
    {
        return 'Edit';
    }
    
    
    /**
     * Get FlatsCount
     *
     * @return integer
     */
    public function getFlatsCount()
    {
        $counter = 0;
        foreach($this->getParads() as $parad)
        {
            $counter += $parad->getFlats()->count();
        }
        
        return $counter;
    }
    
    /**
     * Set descr
     *
     * @param string $descr
     * @return House
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
     * Set payPort
     *
     * @param integer $payPort
     * @return House
     */
    public function setPayPort($payPort)
    {
        $this->payPort = $payPort;
    
        return $this;
    }

    /**
     * Get payPort
     *
     * @return integer 
     */
    public function getPayPort()
    {
        return $this->payPort;
    }
    
    /**
     * Get Switches
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSwitches()
    {
        $switches = array();
        foreach($this->getParads() as $parad)
        {
            foreach($parad->getRacks() as $rack)
            {
                foreach($rack->getSwitchDevices() as $switch)
                {
                    $switches[] = $switch;
                }
            }
        }
        $switches = new ArrayCollection($switches);
        
        return $switches;
    }
    
    /**
     * Get Racks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRacks()
    {
        $racks = array();
        foreach($this->getParads() as $parad)
        {
            foreach($parad->getRacks() as $rack)
            {
                $racks[] = $rack;
            }
        }
        $racks = new ArrayCollection($racks);
        
        return $racks;
    }
    
    /**
     * Get Flats
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFlats()
    {
        $flats = array();
        foreach($this->getParads() as $parad)
        {
            foreach($parad->getFlats() as $flat)
            {
                $flats[] = $flat;
            }
        }
        $flats = new ArrayCollection($flats);
        
        return $flats;
    }
    
    /**
     * hasChildren
     *
     * @return boolean
     */
    public function hasChildren()
    {
        if($this->getParads()->count()) return true;
        return false;
    }

    /**
     * Set houseType
     *
     * @param \Crm\AddressesBundle\Entity\HouseType $houseType
     * @return House
     */
    public function setHouseType(\Crm\AddressesBundle\Entity\HouseType $houseType = null)
    {
        $this->houseType = $houseType;
    
        return $this;
    }

    /**
     * Get houseType
     *
     * @return \Crm\AddressesBundle\Entity\HouseType 
     */
    public function getHouseType()
    {
        return $this->houseType;
    }

    /**
     * Set faza2
     *
     * @param boolean $faza2
     * @return House
     */
    public function setFaza2($faza2)
    {
        $this->faza2 = $faza2;
    
        return $this;
    }

    /**
     * Get faza2
     *
     * @return boolean 
     */
    public function getFaza2()
    {
        return $this->faza2;
    }

    /**
     * Set optika_kan
     *
     * @param boolean $optikaKan
     * @return House
     */
    public function setOptikaKan($optikaKan)
    {
        $this->optika_kan = $optikaKan;
    
        return $this;
    }

    /**
     * Get optika_kan
     *
     * @return boolean 
     */
    public function getOptikaKan()
    {
        return $this->optika_kan;
    }

    /**
     * Set optika_air
     *
     * @param boolean $optikaAir
     * @return House
     */
    public function setOptikaAir($optikaAir)
    {
        $this->optika_air = $optikaAir;
    
        return $this;
    }

    /**
     * Get optika_air
     *
     * @return boolean 
     */
    public function getOptikaAir()
    {
        return $this->optika_air;
    }
}