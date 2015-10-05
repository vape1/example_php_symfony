<?php
namespace Crm\AddressesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Crm\AddressesBundle\Entity\BaseAddress;

/**
 * City
 *
 * @ORM\Table(name="address_city")
 * @ORM\Entity(repositoryClass="Crm\AddressesBundle\Repository\CityRepository")
 */
class City extends BaseAddress
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
     * @ORM\Column(length=255,name="prefix_ru")
     */
    protected $prefixRu;
    
    /**
     * @ORM\Column(length=255,name="prefix_ua")
     */
    protected $prefixUa;
    
    /**
     * @ORM\OneToMany(targetEntity="Crm\AddressesBundle\Entity\Region", mappedBy="city", cascade={"persist"})
     */
    protected $regions;
    
    /**
     * @ORM\OneToMany(targetEntity="Crm\AddressesBundle\Entity\Street", mappedBy="city", cascade={"persist"})
     */
    protected $streets;

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
        $this->regions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->streets = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * toString
     */
    public function __toString()
    {
        return $this->nameUa;
    }
    /**
     * Set prefixRu
     *
     * @param string $prefixRu
     * @return City
     */
    public function setPrefixRu($prefixRu)
    {
        $this->prefixRu = $prefixRu;
    
        return $this;
    }

    /**
     * Get prefixRu
     *
     * @return string 
     */
    public function getPrefixRu()
    {
        return $this->prefixRu;
    }

    /**
     * Set prefixUa
     *
     * @param string $prefixUa
     * @return City
     */
    public function setPrefixUa($prefixUa)
    {
        $this->prefixUa = $prefixUa;
    
        return $this;
    }

    /**
     * Get prefixUa
     *
     * @return string 
     */
    public function getPrefixUa()
    {
        return $this->prefixUa;
    }

    /**
     * Add regions
     *
     * @param \Crm\AddressesBundle\Entity\Region $regions
     * @return City
     */
    public function addRegion(\Crm\AddressesBundle\Entity\Region $regions)
    {
        $this->regions[] = $regions;
    
        return $this;
    }

    /**
     * Remove regions
     *
     * @param \Crm\AddressesBundle\Entity\Region $regions
     */
    public function removeRegion(\Crm\AddressesBundle\Entity\Region $regions)
    {
        $this->regions->removeElement($regions);
    }

    /**
     * Get regions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRegions()
    {
        return $this->regions;
    }

    /**
     * Add streets
     *
     * @param \Crm\AddressesBundle\Entity\Street $streets
     * @return City
     */
    public function addStreet(\Crm\AddressesBundle\Entity\Street $streets)
    {
        $this->streets[] = $streets;
    
        return $this;
    }

    /**
     * Remove streets
     *
     * @param \Crm\AddressesBundle\Entity\Street $streets
     */
    public function removeStreet(\Crm\AddressesBundle\Entity\Street $streets)
    {
        $this->streets->removeElement($streets);
    }

    /**
     * Get streets
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStreets()
    {
        return $this->streets;
    }
    
    /**
     * hasChildren
     *
     * @return boolean
     */
    public function hasChildren()
    {
        if($this->getStreets()->count()) return true;
        return false;
    }
    
    public function getEdit()
    {
        return 'Edit';
    }
}