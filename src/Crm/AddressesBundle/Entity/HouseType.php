<?php

namespace Crm\AddressesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HouseType
 *
 * @ORM\Table(name="address_house_type")
 * @ORM\Entity
 */
class HouseType
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * @ORM\OneToMany(targetEntity="Crm\AddressesBundle\Entity\House", mappedBy="houseType", cascade={"persist"})
     */
    protected $houses;


    /**
     * toString
     */
    public function __toString()
    {
        return $this->name;
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
     * @return HouseType
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
     * Constructor
     */
    public function __construct()
    {
        $this->houses = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add houses
     *
     * @param \Crm\AddressesBundle\Entity\House $houses
     * @return HouseType
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
}