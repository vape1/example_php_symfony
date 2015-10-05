<?php

namespace Crm\AddressesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Brand
 *
 * @ORM\Table(name="address_parad_brand")
 * @ORM\Entity
 */
class Brand
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
     * @ORM\ManyToOne(targetEntity="Crm\AddressesBundle\Entity\Parad", inversedBy="brands")
     * @ORM\JoinColumn(name="parad_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $parad;
    
    /**
     * @ORM\ManyToOne(targetEntity="Crm\AddressesBundle\Entity\BrandType", inversedBy="brands")
     * @ORM\JoinColumn(name="brand_type_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $brandType;
    
    /**
     * @ORM\ManyToOne(targetEntity="Zk\UserBundle\Entity\User", inversedBy="brands")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $installer;
    
    /**
     * @ORM\Column(name="date_install",type="datetime",nullable=true)
     */
    protected $dateInstall;
    
    /**
     * @ORM\Column(name="prom_door_parad",type="boolean")
     */
    protected $prom_door_parad;
    
    /**
     * @ORM\Column(name="prom_lift_door",type="boolean")
     */
    protected $prom_lift_door;
    
    /**
     * @ORM\Column(name="prom_shield",type="boolean")
     */
    protected $prom_shield;
    
    /**
     * @ORM\Column(name="planned",type="boolean")
     */
    protected $planned;

    /**
     * @ORM\Column(name="descr",type="text",nullable=true)
     */
    protected $descr;
    
     /**
     * Constructor
     */
    public function __construct(Parad $parad,BrandType $brand)
    {
        $this->parad = $parad;
        $this->brandType = $brand;
        $this->planned = false;
        $this->prom_shield = false;
        $this->prom_lift_door = false;
        $this->prom_door_parad = false;
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
     * @return Brand
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
     * Set dateInstall
     *
     * @param \DateTime $dateInstall
     * @return Brand
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
     * Set parad
     *
     * @param \Crm\AddressesBundle\Entity\Parad $parad
     * @return Brand
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
     * Set brandType
     *
     * @param \Crm\AddressesBundle\Entity\BrandType $brandType
     * @return Brand
     */
    public function setBrandType(\Crm\AddressesBundle\Entity\BrandType $brandType = null)
    {
        $this->brandType = $brandType;
    
        return $this;
    }

    /**
     * Get brandType
     *
     * @return \Crm\AddressesBundle\Entity\BrandType 
     */
    public function getBrandType()
    {
        return $this->brandType;
    }

    /**
     * Set planned
     *
     * @param boolean $planned
     * @return Brand
     */
    public function setPlanned($planned)
    {
        $this->planned = $planned;
    
        return $this;
    }

    /**
     * Get planned
     *
     * @return boolean 
     */
    public function getPlanned()
    {
        return $this->planned;
    }

    /**
     * Set prom_door_parad
     *
     * @param boolean $promDoorParad
     * @return Brand
     */
    public function setPromDoorParad($promDoorParad)
    {
        $this->prom_door_parad = $promDoorParad;
    
        return $this;
    }

    /**
     * Get prom_door_parad
     *
     * @return boolean 
     */
    public function getPromDoorParad()
    {
        return $this->prom_door_parad;
    }

    /**
     * Set prom_lift_door
     *
     * @param boolean $promLiftDoor
     * @return Brand
     */
    public function setPromLiftDoor($promLiftDoor)
    {
        $this->prom_lift_door = $promLiftDoor;
    
        return $this;
    }

    /**
     * Get prom_lift_door
     *
     * @return boolean 
     */
    public function getPromLiftDoor()
    {
        return $this->prom_lift_door;
    }

    /**
     * Set prom_shield
     *
     * @param boolean $promShield
     * @return Brand
     */
    public function setPromShield($promShield)
    {
        $this->prom_shield = $promShield;
    
        return $this;
    }

    /**
     * Get prom_shield
     *
     * @return boolean 
     */
    public function getPromShield()
    {
        return $this->prom_shield;
    }

    /**
     * Set descr
     *
     * @param string $descr
     * @return Brand
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
     * IsPromotion
     *
     * @return boolean
     */
    public function isPromotion()
    {
        $res = $this->getBrandType()->getId() == 3 ? true : false;
        return $res;
    }

    /**
     * Set installer
     *
     * @param \Zk\UserBundle\Entity\User $installer
     * @return Brand
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
    public function getParadName()
    {
        return $this->getParad()->getName();
    }
    
    /**
     * Get EprasysNameHouse
     *
     * @return string
     */
    public function getEprasysNameHouse()
    {
        return $this->getParad()->getEprasysName();
    }
    
    /**
     * Get EprasysNameHouse
     *
     * @return string
     */
    public function getEprasysNameParad()
    {
        return $this->getParad()->getEprasysName();
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
    public function getHouseName()
    {
        return  $this->getParad()->getHouseName();
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
     * Get StreetId
     *
     * @return integer
     */
    public function getStreetId()
    {
        $streetId = $this->getParad()->getStreetId();
        return  $streetId;
    }
    
    /**
     * Get HouseId
     *
     * @return integer
     */
    public function getHouseId()
    {
        return  $this->getParad()->getHouseId();
    }
    
    public function getEdit()
    {
        return 'Edit';
    }

    /**
     * Set floor
     *
     * @param integer $floor
     * @return Flat
     */
    public function setFloor($floor)
    {
        $this->floor = $floor;
    
        return $this;
    }

    
    /**
     * getFaza
     *
     * @return integer 
     */
    public function getFaza()
    {
        return $this->getParad()->getFaza();
    }
    
    
    /**
     * getAccessParad
     *
     * @return integer 
     */
    public function getAccessParad()
    {
        return $this->getParad()->getAccessParad();
    }
    
    /**
     * getCommentAccessParad
     *
     * @return integer 
     */
    public function getCommentAccessParad()
    {
        return $this->getParad()->getCommentAccessParad();
    }
    
    /**
     * getAddressKey
     *
     * @return integer 
     */
    public function getAddressKey()
    {
        return $this->getParad()->getAddressKey();
    }
    
    /**
     * getCommentDateConn
     *
     * @return integer 
     */
    public function getCommentDateConn()
    {
        return $this->getParad()->getCommentDateConn();
    }
    
    /**
     * getBilinkStoyak
     *
     * @return integer 
     */
    public function getBilinkStoyak()
    {
        return $this->getParad()->getBilinkStoyak();
    }
    
    /**
     * getSemafor
     *
     * @return integer 
     */
    public function getSemafor()
    {
        return $this->getParad()->getSemafor();
    }
}