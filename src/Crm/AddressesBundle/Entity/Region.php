<?php
namespace Crm\AddressesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Crm\AddressesBundle\Entity\BaseAddress;

/**
 * Region
 *
 * @ORM\Table(name="address_region")
 * @ORM\Entity(repositoryClass="Crm\AddressesBundle\Repository\RegionRepository")
 */
class Region extends BaseAddress
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
     * @ORM\ManyToOne(targetEntity="Crm\AddressesBundle\Entity\City", inversedBy="regions")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $city;
    
    /**
     * @ORM\OneToMany(targetEntity="Crm\AddressesBundle\Entity\House", mappedBy="region", cascade={"persist"})
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
     * Set city
     *
     * @param \Crm\AddressesBundle\Entity\City $city
     * @return Region
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
     * Constructor
     */
    public function __construct()
    {
        $this->houses = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Constructor
     */
    public function __toString()
    {
        return $this->nameRu;
    }
    
    /**
     * Add houses
     *
     * @param \Crm\AddressesBundle\Entity\House $houses
     * @return Region
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
}