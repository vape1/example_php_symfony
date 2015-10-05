<?php

namespace Crm\AddressesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RivalTv
 *
 * @ORM\Table(name="address_rival")
 * @ORM\Entity
 */
class Rival
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
     * @ORM\OneToMany(targetEntity="Crm\AddressesBundle\Entity\Flat", mappedBy="rival", cascade={"persist"})
     */
    protected $flats;
    
    /**
     * @ORM\OneToMany(targetEntity="Crm\AbonentBundle\Entity\OffInfo", mappedBy="rival", cascade={"persist"})
     */
    protected $offInfo;
    
    /**
     * @ORM\OneToMany(targetEntity="Crm\AbonentBundle\Entity\Appl", mappedBy="rival", cascade={"persist"})
     */
    protected $appl;
    
    /**
     * @ORM\Column(length=255,name="name")
     */
    protected $name;
    
    /**
     * @ORM\Column(type="text",name="descr")
     */
    protected $descr;
    
    /**
     * @ORM\Column(type="boolean",name="inet")
     */
    protected $inet;
    
    /**
     * @ORM\Column(type="boolean",name="tv")
     */
    protected $tv;
    
    /**
     * @ORM\Column(type="boolean",name="active")
     */
    protected $active;
    
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
        $this->flats = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return RivalTv
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
     * Add flats
     *
     * @param \Crm\AddressesBundle\Entity\Flat $flats
     * @return RivalTv
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
     * Add offInfo
     *
     * @param \Crm\AbonentBundle\Entity\OffInfo $offInfo
     * @return Rival
     */
    public function addOffInfo(\Crm\AbonentBundle\Entity\OffInfo $offInfo)
    {
        $this->offInfo[] = $offInfo;
    
        return $this;
    }

    /**
     * Remove offInfo
     *
     * @param \Crm\AbonentBundle\Entity\OffInfo $offInfo
     */
    public function removeOffInfo(\Crm\AbonentBundle\Entity\OffInfo $offInfo)
    {
        $this->offInfo->removeElement($offInfo);
    }

    /**
     * Get offInfo
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOffInfo()
    {
        return $this->offInfo;
    }

    /**
     * Add appl
     *
     * @param \Crm\AbonentBundle\Entity\Appl $appl
     * @return Rival
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

    /**
     * Set descr
     *
     * @param string $descr
     * @return Rival
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
     * Set inet
     *
     * @param boolean $inet
     * @return Rival
     */
    public function setInet($inet)
    {
        $this->inet = $inet;
    
        return $this;
    }

    /**
     * Get inet
     *
     * @return boolean 
     */
    public function getInet()
    {
        return $this->inet;
    }

    /**
     * Set tv
     *
     * @param boolean $tv
     * @return Rival
     */
    public function setTv($tv)
    {
        $this->tv = $tv;
    
        return $this;
    }

    /**
     * Get tv
     *
     * @return boolean 
     */
    public function getTv()
    {
        return $this->tv;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Rival
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
}