<?php

namespace Crm\AddressesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Parad
 *
 * @ORM\Table(name="address_parad")
 * @ORM\Entity(repositoryClass="Crm\AddressesBundle\Repository\ParadRepository")
 * @UniqueEntity("eprasysName")
 * 
 */
class Parad
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
     * @ORM\ManyToOne(targetEntity="Crm\AddressesBundle\Entity\House", inversedBy="parads")
     * @ORM\JoinColumn(name="house_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $house;
    
    /**
     * @ORM\OneToMany(targetEntity="Crm\AddressesBundle\Entity\Flat", mappedBy="parad", cascade={"persist"})
     * @OrderBy({"name" = "ASC"})
     */
    protected $flats;
    
    /**
     * @ORM\OneToMany(targetEntity="Crm\AddressesBundle\Entity\Rack", mappedBy="parad", cascade={"persist"})
     * @OrderBy({"eprasysName" = "ASC"})
     */
    protected $racks;
    
    /**
     * @ORM\OneToMany(targetEntity="Crm\AddressesBundle\Entity\Brand", mappedBy="parad", cascade={"persist"})
     */
    protected $brands;
    
    /**
     * @ORM\ManyToOne(targetEntity="Crm\AddressesBundle\Entity\ServiceOrgDep", inversedBy="parads")
     * @ORM\JoinColumn(name="service_org_dep_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $serviceOrgDep;
    
    /**
     * @ORM\Column(length=255,name="name")
     */
    protected $name;
    
    /**
     * @ORM\Column(type="boolean",name="access_parad")
     */
    protected $accessParad;
    
    /**
     * @ORM\Column(length=255,name="comment_access_parad",nullable=true)
     */
    protected $commentAccessParad;
    
    /**
     * @ORM\Column(type="integer",name="faza")
     */
    protected $faza;
    
    /**
     * @ORM\Column(type="boolean",name="faza2")
     */
    protected $faza2;
    
    /**
     * @ORM\Column(type="integer",name="bilink_stoyak")
     */
    protected $bilinkStoyak;
    
    /**
     * @ORM\Column(type="integer",name="semafor")
     */
    protected $semafor;
    
    /**
     * @ORM\Column(length=255,name="condition_parad",nullable=true)
     */
    protected $conditionParad;
    
    /**
     * @ORM\Column(type="text",name="descr_parad", nullable=true)
     */
    protected $descrParad;
    
    /**
     * @ORM\Column(type="integer",name="floor")
     */
    protected $floor;
    
    /**
     * @ORM\Column(type="boolean",name="able_conn")
     */
    protected $ableConn;
    
    /**
     * @ORM\Column(name="date_conn",type="datetime",nullable=true)
     */
    protected $dateConn;
    
    /**
     * @ORM\Column(length=255,name="eprasys_name")
     */
    protected $eprasysName;
    
    /**
     * @ORM\Column(type="integer",name="lift_quan")
     */
    protected $liftQuan;

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
    public function __construct(House $house)
    {
        $this->flats = new \Doctrine\Common\Collections\ArrayCollection();
        $this->house = $house;
        $this->bilinkStoyak = false;
        $this->connectedAbonents = 0;
        $this->accessParad = false;
        $this->bilinkStoyak = 0;
        $this->floor = 1;
        $this->liftQuan = 1;
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
     * @return Parad
     */
    public function setEprasysName()
    {
        $eprasys_name_house = $this->getHouse()->getEprasysName().'('.$this->getName().')';
        $this->eprasysName = $eprasys_name_house;
      
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
     * Get eprasysNameParad
     *
     * @return string 
     */
    public function getEprasysNameParad()
    {
        return $this->eprasysName;
    }

    /**
     * Set house
     *
     * @param \Crm\AddressesBundle\Entity\House $house
     * @return Parad
     */
    public function setHouse(\Crm\AddressesBundle\Entity\House $house = null)
    {
        $this->house = $house;
    
        return $this;
    }

    /**
     * Get house
     *
     * @return \Crm\AddressesBundle\Entity\House 
     */
    public function getHouse()
    {
        return $this->house;
    }

    /**
     * Add flats
     *
     * @param \Crm\AddressesBundle\Entity\Flat $flats
     * @return Parad
     */
    public function addFlat(\Crm\AddressesBundle\Entity\Flat $flats)
    {
        $this->flats[] = $flats;
    
        return $this;
    }

    /**
     * Remove flats
     *
     * @param \Crm\AddressesBundle\Entity\Flat $flats
     */
    public function removeFlat(\Crm\AddressesBundle\Entity\Flat $flats)
    {
        $this->flats->removeElement($flats);
    }

    /**
     * Get flats
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFlats()
    {
        return $this->flats;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Parad
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
     * Set accessParad
     *
     * @param $accessParad
     * @return boolean
     */
    public function setAccessParad( $accessParad)
    {
        $this->accessParad = $accessParad;
    
        return $this;
    }

    /**
     * Get accessParad
     *
     * @return boolean
     */
    public function getAccessParad()
    {
        return $this->accessParad;
    }

    /**
     * Set commentAccessParad
     *
     * @param string $commentAccessParad
     * @return Parad
     */
    public function setCommentAccessParad($commentAccessParad)
    {
        $this->commentAccessParad = $commentAccessParad;
    
        return $this;
    }

    /**
     * Get commentAccessParad
     *
     * @return string 
     */
    public function getCommentAccessParad()
    {
        return $this->commentAccessParad;
    }


    /**
     * Set planDateConn
     *
     * @param \DateTime $planDateConn
     * @return Parad
     */
    public function setDateConn($planDateConn)
    {
        $this->dateConn = $planDateConn;
    
        return $this;
    }

    /**
     * Get planDateConn
     *
     * @return \DateTime 
     */
    public function getDateConn()
    {
        return $this->dateConn;
    }

    /**
     * Set faza
     *
     * @param integer $faza
     * @return Parad
     */
    public function setFaza($faza)
    {
        $this->faza = $faza;
    
        return $this;
    }

    /**
     * Get faza
     *
     * @return integer 
     */
    public function getFaza()
    {
        return $this->faza;
    }

    /**
     * Set semafor
     *
     * @param integer $semafor
     * @return Parad
     */
    public function setSemafor($semafor)
    {
        $this->semafor = $semafor;
    
        return $this;
    }

    /**
     * Get semafor
     *
     * @return integer 
     */
    public function getSemafor()
    {
        return $this->semafor;
    }

    /**
     * Set conditionParad
     *
     * @param string $conditionParad
     * @return Parad
     */
    public function setConditionParad($conditionParad)
    {
        $this->conditionParad = $conditionParad;
    
        return $this;
    }

    /**
     * Get conditionParad
     *
     * @return string 
     */
    public function getConditionParad()
    {
        return $this->conditionParad;
    }

    /**
     * Set serviceOrg
     *
     * @param \Crm\AddressesBundle\Entity\ServiceOrgDep $serviceOrgDep
     * @return Parad
     */
    public function setServiceOrgDep(\Crm\AddressesBundle\Entity\ServiceOrgDep $serviceOrgDep = null)
    {
        $this->serviceOrgDep = $serviceOrgDep;
    
        return $this;
    }

    /**
     * Get serviceOrg
     *
     * @return \Crm\AddressesBundle\Entity\ServiceOrg 
     */
    public function getServiceOrgDep()
    {
        return $this->serviceOrgDep;
    }
    
    /**
     * Get city
     *
     * @return string
     */
    public function getCityName()
    {
        $city = $this->getHouse()->getCityName();
        return $city;
    }
    
    /**
     * Get street
     *
     * @return string 
     */
    public function getStreetNameUa()
    {
        $street =  $this->getHouse()->getStreetNameRu();
        return $street;
    }
    
    /**
     * Get street
     *
     * @return string
     */
    public function getStreetNameRu()
    {
        $street =  $this->getHouse()->getStreetNameUa();
        return $street;
    }
    
    /**
     * Get name
     *
     * @return string
     */
    public function getHouseName()
    {
        return $this->getHouse()->getName();
    }
    
     /**
     * Get EprasysNameHouse
     *
     * @return string
     */
    public function getEprasysNameHouse()
    {
        return $this->getHouse()->getEprasysName();
    }
    
    /**
     * Get BilinkRegion
     *
     * @return string 
     */
    public function getBilinkRegion()
    {
        $bilinkRegion = $this->getHouse()->getBilinkRegion();
        return  $bilinkRegion;
    }
    
    /**
     * Get Region
     *
     * @return string 
     */
    public function getRegion()
    {
        return  $this->getHouse()->getRegion();
    }
    
    /**
     * Get subRegion
     *
     * @return string 
     */
    public function getSubRegion()
    {
        return  $this->getHouse()->getSubRegion();
    }
    
     /**
     * Get name
     *
     * @return string 
     */
    public function getParadName()
    {
        return  $this->name;
    }
    
    /**
     * Get HouseId
     *
     * @return integer
     */
    public function getHouseId()
    {
        $houseId = $this->getHouse()->getId();
        return  $houseId;
    }
    
    /**
     * Get StreetId
     *
     * @return integer
     */
    public function getStreetId()
    {
        $streetId = $this->getHouse()->getStreetId();
        return  $streetId;
    }
    
    /**
     * Get getAddressKey
     *
     * @return integer
     */
    public function getAddressKey()
    {
        $address_key = $this->getServiceOrgDep() ? $this->getServiceOrgDep()->getKeyAddress() : '';
        return  $address_key;
    }
    
    /**
     * Get ParadId
     *
     * @return integer
     */
    public function getParadId()
    {
        return  $this->getId();
    }
    
    public function getEdit()
    {
        return 'Edit';
    }

    /**
     * Set faza2
     *
     * @param integer $faza2
     * @return Parad
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
     * Set bilinkStoyak
     *
     * @param integer $bilinkStoyak
     * @return Parad
     */
    public function setBilinkStoyak($bilinkStoyak)
    {
        $this->bilinkStoyak = $bilinkStoyak;
    
        return $this;
    }

    /**
     * Get bilinkStoyak
     *
     * @return integer 
     */
    public function getBilinkStoyak()
    {
        return $this->bilinkStoyak;
    }

    /**
     * Set descrParad
     *
     * @param string $descrParad
     * @return Parad
     */
    public function setDescrParad($descrParad)
    {
        $this->descrParad = $descrParad;
    
        return $this;
    }

    /**
     * Get descrParad
     *
     * @return string 
     */
    public function getDescrParad()
    {
        return $this->descrParad;
    }

    /**
     * Set floor
     *
     * @param integer $floor
     * @return Parad
     */
    public function setFloor($floor)
    {
        $this->floor = $floor;
    
        return $this;
    }

    /**
     * Get floor
     *
     * @return integer 
     */
    public function getFloor()
    {
        return $this->floor;
    }

    /**
     * Set ableConn
     *
     * @param integer $ableConn
     * @return Parad
     */
    public function setAbleConn($ableConn)
    {
        $this->ableConn = $ableConn;
    
        return $this;
    }

    /**
     * Get ableConn
     *
     * @return integer 
     */
    public function getAbleConn()
    {
        return $this->ableConn;
    }
    
    /**
     * getPromotion
     *
     * @return Brand
     */
    public function getPromotion()
    {
        return $this->getBrands()->filter(function($brand) {
            return 3 === $brand->getBrandType()->getId(); 
        });
    }
    
    /**
     * getMirrors
     *
     * @return Brand
     */
    public function getMirrors()
    {
        return $this->getBrands()->filter(function($brand) {
            return 1 === $brand->getBrandType()->getId(); 
        });
    }
    
    /**
     * getMirrorsCount
     *
     * @return integr
     */
    public function getMirrorsCount()
    {
        return $this->getMirrors()->filter(function($brand) {
            return !$brand->getPlanned(); 
        })->count();
    }
    
    /**
     * getMirrorsCountPlanned
     *
     * @return integr
     */
    public function getMirrorsCountPlanned()
    {
        return $this->getMirrors()->filter(function($brand) {
            return $brand->getPlanned(); 
        })->count();
    }
    
    /**
     * getTableQuan
     *
     * @return Brand
     */
    public function getTable()
    {
        return $this->getBrands()->filter(function($brand) {
            return 2 === $brand->getBrandType()->getId(); 
        });
    }

    /**
     * Set liftQuan
     *
     * @param integer $liftQuan
     * @return Parad
     */
    public function setLiftQuan($liftQuan)
    {
        $this->liftQuan = $liftQuan;
    
        return $this;
    }

    /**
     * Get liftQuan
     *
     * @return integer 
     */
    public function getLiftQuan()
    {
        return $this->liftQuan;
    }

    /**
     * Add brands
     *
     * @param \Crm\AddressesBundle\Entity\Brand $brands
     * @return Parad
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
     * Add racks
     *
     * @param \Crm\AddressesBundle\Entity\Rack $racks
     * @return Parad
     */
    public function addRack(\Crm\AddressesBundle\Entity\Rack $racks)
    {
        $this->racks[] = $racks;
    
        return $this;
    }

    /**
     * Remove racks
     *
     * @param \Crm\AddressesBundle\Entity\Rack $racks
     */
    public function removeRack(\Crm\AddressesBundle\Entity\Rack $racks)
    {
        $this->racks->removeElement($racks);
    }

    /**
     * Get racks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRacks()
    {
        return $this->racks;
    }
    
    /**
     * Get SwitchDeviceQuan
     *
     * @return integer
     */
    public function getSwitchDevicesQuan()
    {
        $counter = 0;
        foreach($this->getRacks() as $rack)
        {
            $counter += $rack->getSwitchDevices()->count();
        }
        
        return $counter;
    }
    
    /**
     * hasChildren
     *
     * @return boolean
     */
    public function hasChildren()
    {
        if($this->getRacks()->count()) return true;
        return false;
    }
    
    /**
     * get int part of number
     *
     * @return integer 
     */
    public function getNumberInt($number)
    {
        preg_match('/(\d+)/u',$number,$int);
        return $int[0];
    }
    
    /**
     * Find flat floor
     *
     * @return integer 
     */
    public function findFlatFloor($number)
    {
        $int_number = $this->getNumberInt($number);
        $int_parad = $this->getNumberInt($this->getName());
        
        
        //если на этаже 4 квартиры
        $floor = floor(($int_number - ($int_parad - 1)*$this->getFloor()*4)/4-0.0009)+1; 
        
        return $floor;
    }
    
    /**
     * is Unique Flat number
     *
     * @return integer 
     */
    public function isUniqueFlat($number)  
    {
        foreach($this->getHouse()->getFlats() as $house_flat)
        {
            if($house_flat->getNumber() == $number)return false;
        }
        return true;
    }
}