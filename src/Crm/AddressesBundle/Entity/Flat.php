<?php

namespace Crm\AddressesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Flat
 *
 * @ORM\Table(name="address_flat")
 * @ORM\Entity(repositoryClass="Crm\AddressesBundle\Repository\FlatRepository")
 */
class Flat
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
     * @ORM\ManyToOne(targetEntity="Crm\AddressesBundle\Entity\Parad", inversedBy="flats")
     * @ORM\JoinColumn(name="parad_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $parad;
    
    /**
     * @ORM\OneToMany(targetEntity="Crm\AddressesBundle\Entity\FlatPhone", mappedBy="flat", cascade={"persist"})
     */
    protected $flatPhones;

    /**
     * @ORM\Column(length=255,name="name")
     */
    protected $name;
    
    /**
     * @ORM\Column(type="integer",name="status")
     */
    protected $status;
    
    /**
     * @ORM\Column(type="integer",name="floor")
     */
    protected $floor;
    
    /**
     * @ORM\ManyToOne(targetEntity="Crm\AddressesBundle\Entity\Rival", inversedBy="flats")
     * @ORM\JoinColumn(name="rival_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $rival;
    
    /**
     * @ORM\Column(type="text",name="status_descr",nullable=true)
     */
    protected $statusDescr;
    
    /**
     * @ORM\Column(type="text",name="flat_descr",nullable=true)
     */
    protected $flatDescr;
    
    /**
     * @ORM\OneToMany(targetEntity="Crm\AbonentBundle\Entity\AbonentPh", mappedBy="flat", cascade={"persist"})
     */
    protected $abonents;

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
    public function __construct($parad)
    {
        $this->flatPhones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->status = 0;
        $this->parad = $parad;
    }
    
    /**
     * toString
     */
    public function __toString()
    {
        return $this->name;
    }
    
    /**                                                                                                                                                        
     * @Assert\True(message = "Не коректний шаблон для генерації квартир!")                                                                    
     */
    public function isValidNumber()
    {
        preg_match('/(\d+-\d+)|(\d+\/\d)|(\d+[a-zA-Z])|(\d+)/u', $this->getNumber(), $matches);
        if(empty($matches)) return false;
    }
   
    
    /**
     * Set parad
     *
     * @param \Crm\AddressesBundle\Entity\Parad $parad
     * @return Flat
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
     * Add flatPhones
     *
     * @param \Crm\AddressesBundle\Entity\Flat $flatPhones
     * @return FlatPhone
     */
    public function addFlatPhone(\Crm\AddressesBundle\Entity\FlatPhone $flatPhones)
    {
        $this->flatPhones[] = $flatPhones;
    
        return $this;
    }

    /**
     * Remove flatPhones
     *
     * @param \Crm\AddressesBundle\Entity\Flat $flatPhones
     */
    public function removeFlatPhone(\Crm\AddressesBundle\Entity\FlatPhone $flatPhones)
    {
        $this->flatPhones->removeElement($flatPhones);
    }

    /**
     * Get flatPhones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFlatPhones()
    {
        return $this->flatPhones;
    }

    /**
     * Set number
     *
     * @param string $number
     * @return Flat
     */
    public function setName($number)
    {
        $this->name = $number;
    
        return $this;
    }

    /**
     * Get number
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Set status
     *
     * @param integer $status
     * @return Flat
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set statusDescr
     *
     * @param string $statusDescr
     * @return Flat
     */
    public function setStatusDescr($statusDescr)
    {
        $this->statusDescr = $statusDescr;
    
        return $this;
    }

    /**
     * Get statusDescr
     *
     * @return string 
     */
    public function getStatusDescr()
    {
        return $this->statusDescr;
    }

    /**
     * Set Rival
     *
     * @param \Crm\AddressesBundle\Entity\Rival $rival
     * @return Flat
     */
    public function setRival(\Crm\AddressesBundle\Entity\Rival $rival = null)
    {
        $this->rival = $rival;
    
        return $this;
    }

    /**
     * Get Rival
     *
     * @return \Crm\AddressesBundle\Entity\Rival
     */
    public function getRival()
    {
        return $this->rival;
    }
    
     /**
     * Set flatDescr
     *
     * @param string $flatDescr
     * @return Flat
     */
    public function setFlatDescr($flatDescr)
    {
        $this->flatDescr = $flatDescr;
    
        return $this;
    }

    /**
     * Get flatDescr
     *
     * @return string 
     */
    public function getFlatDescr()
    {
        return $this->flatDescr;
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
    
    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        $flat = $this->getName();
        $parad = $this->getParadName();
        $house = $this->getHouseName();
        $street = $this->getStreetNameUa();
        $city = $this->getCityName();
        
        return $city.', '.$street.', '.$house.', кв.'.$flat;
    }

    /**
     * Add abonents
     *
     * @param \Crm\AddressesBundle\Entity\AbonentPh $abonents
     * @return Flat
     */
    public function addAbonent(\Crm\AbonentBundle\Entity\AbonentPh $abonents)
    {
        $this->abonents[] = $abonents;
    
        return $this;
    }

    /**
     * Remove abonents
     *
     * @param \Crm\AbonentBundle\Entity\AbonentPh $abonents
     */
    public function removeAbonent(\Crm\AbonentBundle\Entity\AbonentPh $abonents)
    {
        $this->abonents->removeElement($abonents);
    }

    /**
     * Get abonents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAbonents()
    {
        return $this->abonents;
    }
    
    public function getAbonentsInfo()
    {
        $array = array();
        foreach($this->getAbonents() as $abonent)
        {
            $array[] = array('id'=>$abonent->getId(), 'name'=>$abonent->getSurName().' '.$abonent->getFirstName(), 'dogovor'=>$abonent->getNumDogovor());
        }
        
        return $array;
    }
}