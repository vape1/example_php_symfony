<?php

namespace Crm\AddressesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BrandType
 *
 * @ORM\Table(name="address_parad_brand_type")
 * @ORM\Entity
 */
class BrandType
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
     * @ORM\OneToMany(targetEntity="Crm\AddressesBundle\Entity\Brand", mappedBy="brandType", cascade={"persist"})
     */
    protected $brands;
    
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


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
     * @return BrandType
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
        $this->brands = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add brands
     *
     * @param \Crm\AddressesBundle\Entity\Brand $brands
     * @return BrandType
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
}