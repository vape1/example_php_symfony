<?php

namespace Crm\AddressesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Crm\AddressesBundle\Entity\BaseAddress;

/**
 * SubRegion
 *
 * @ORM\Table(name="address_sub_region")
 * @ORM\Entity(repositoryClass="Crm\AddressesBundle\Repository\SubRegionRepository")
 */
class SubRegion extends BaseAddress
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
     * @ORM\ManyToOne(targetEntity="Crm\AddressesBundle\Entity\BilinkRegion", inversedBy="subRegions")
     * @ORM\JoinColumn(name="bilink_region_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $bilinkRegion;
    
    /**
     * @ORM\OneToMany(targetEntity="Crm\AddressesBundle\Entity\House", mappedBy="subRegion", cascade={"persist"})
     */
    protected $houses;

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
     * Set bilinkRegion
     *
     * @param \Crm\AddressesBundle\Entity\BilinkRegion $bilinkRegion
     * @return SubRegion
     */
    public function setBilinkRegion(\Crm\AddressesBundle\Entity\BilinkRegion $bilinkRegion = null)
    {
        $this->bilinkRegion = $bilinkRegion;
    
        return $this;
    }

    /**
     * Get bilinkRegion
     *
     * @return \Crm\AddressesBundle\Entity\BilinkRegion 
     */
    public function getBilinkRegion()
    {
        return $this->bilinkRegion;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->houses = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * toString
     */
    public function __toString()
    {
        return $this->nameRu;
    }

    /**
     * Add houses
     *
     * @param \Crm\AddressesBundle\Entity\House $houses
     * @return SubRegion
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