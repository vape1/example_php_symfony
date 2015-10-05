<?php

namespace Crm\AddressesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Crm\AddressesBundle\Entity\BaseAddress;

/**
 * BilinkRegion
 *
 * @ORM\Table(name="address_bilink_region")
 * @ORM\Entity(repositoryClass="Crm\AddressesBundle\Repository\BilinkRegionRepository")
 */
class BilinkRegion extends BaseAddress
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
     * @ORM\OneToMany(targetEntity="Crm\AddressesBundle\Entity\SubRegion", mappedBy="bilinkRegion", cascade={"persist"})
     */
    protected $subRegions;


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
        $this->subRegions = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Constructor
     */
    public function __toString()
    {
        return $this->nameRu;
    }

    /**
     * Add subRegions
     *
     * @param \Crm\AddressesBundle\Entity\SubRegion $subRegions
     * @return BilinkRegion
     */
    public function addSubRegion(\Crm\AddressesBundle\Entity\SubRegion $subRegions)
    {
        $this->subRegions[] = $subRegions;
    
        return $this;
    }

    /**
     * Remove subRegions
     *
     * @param \Crm\AddressesBundle\Entity\SubRegion $subRegions
     */
    public function removeSubRegion(\Crm\AddressesBundle\Entity\SubRegion $subRegions)
    {
        $this->subRegions->removeElement($subRegions);
    }

    /**
     * Get subRegions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubRegions()
    {
        return $this->subRegions;
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
        if($this->getSubRegions()->count()) return true;
        return false;
    }
}