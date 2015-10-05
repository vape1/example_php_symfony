<?php

namespace Crm\AddressesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Crm\AddressesBundle\Entity\BaseAddress;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Street
 *
 * @ORM\Table(name="address_street")
 * @ORM\Entity(repositoryClass="Crm\AddressesBundle\Repository\StreetRepository")
 * @UniqueEntity("eprasysName")
 */
class Street extends BaseAddress
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(length=255,name="eprasys_name")
     */
    protected $eprasysName;
    
    /**
     * @ORM\Column(length=255,name="type_street_ru")
     */
    protected $typeStreetRu;
    
    /**
     * @ORM\Column(length=255,name="type_street_ua")
     */
    protected $typeStreetUa;

    /**
     * @ORM\ManyToOne(targetEntity="Crm\AddressesBundle\Entity\City", inversedBy="streets")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $city;
    
    /**
     * @ORM\OneToMany(targetEntity="Crm\AddressesBundle\Entity\House", mappedBy="street", cascade={"persist"})
     */
    protected $houses;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->houses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->typeStreetRu = 'ул.';
        $this->typeStreetUa = 'вул.';
    }

    /**
     * toString
     */
    public function __toString()
    {
        return $this->nameRu;
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
     * Set eprasysName
     *
     * @param string $eprasysName
     * @return Street
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
     * Set typeStreetRu
     *
     * @param string $typeStreetRu
     * @return Street
     */
    public function setTypeStreetRu($typeStreetRu)
    {
        $this->typeStreetRu = $typeStreetRu;
    
        return $this;
    }

    /**
     * Get typeStreetRu
     *
     * @return string 
     */
    public function getTypeStreetRu()
    {
        return $this->typeStreetRu;
    }

    /**
     * Set typeStreetUa
     *
     * @param string $typeStreetUa
     * @return Street
     */
    public function setTypeStreetUa($typeStreetUa)
    {
        $this->typeStreetUa = $typeStreetUa;
    
        return $this;
    }

    /**
     * Get typeStreetUa
     *
     * @return string 
     */
    public function getTypeStreetUa()
    {
        return $this->typeStreetUa;
    }

    /**
     * Set city
     *
     * @param \Crm\AddressesBundle\Entity\City $city
     * @return Street
     */
    public function setCity(\Crm\AddressesBundle\Entity\City $city = null)
    {
        $this->city = $city;
    
        return $this;
    }

    /**
     * Get city
     *
     * @return \Crm\AddressesBundle\Entity\City 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Add houses
     *
     * @param \Crm\AddressesBundle\Entity\House $houses
     * @return Street
     */
    public function addHouse(\Crm\AddressesBundle\Entity\House $houses)
    {
        $this->houses[] = $houses;
    
        return $this;
    }

    /**
     * Remove houses
     *
     * @param \Crm\AddressesBundle\Entity\House $houses
     */
    public function removeHouse(\Crm\AddressesBundle\Entity\House $houses)
    {
        $this->houses->removeElement($houses);
    }

    /**
     * Get houses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHouses()
    {
        return $this->houses;
    }
    
    /**
     * Get cityName
     *
     * @return string
     */
    public function getCityName()
    {
        return $this->getCity()->getNameUa();
    }
    
    /**
     * Get streetName
     *
     * @return string
     */
    public function getStreetNameUa()
    {
        $street = $this->typeStreetUa." ".$this->nameUa;
        return $street;
    }
    
    /**
     * Get streetNameRu
     *
     * @return string
     */
    public function getStreetNameRu()
    {
        $street = $this->typeStreetRu." ".$this->nameRu;
        return $street;
    }
    
    /**
     * Get StreetId
     *
     * @return integer
     */
    public function getStreetId()
    {
        return  $this->getId();
    }
    
    public function getEdit()
    {
        return 'Edit';
    }
    
    /**
     * hasChildren
     *
     * @return boolean
     */
    public function hasChildren()
    {
        if($this->getHouses()->count()) return true;
        return false;
    }
}