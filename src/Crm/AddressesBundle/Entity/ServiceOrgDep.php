<?php

namespace Crm\AddressesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ServiceOrg
 *
 * @ORM\Table(name="address_service_org_dep")
 * @ORM\Entity
 */
class ServiceOrgDep
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
     * @ORM\OneToMany(targetEntity="Crm\AddressesBundle\Entity\Parad", mappedBy="serviceOrgDep", cascade={"persist"})
     */
    protected $parads;
    
    /**
     * @ORM\ManyToOne(targetEntity="Crm\AddressesBundle\Entity\ServiceOrg", inversedBy="serviceOrgDeps")
     * @ORM\JoinColumn(name="service_org_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $serviceOrg;
    
    /**
     * @ORM\Column(length=255,name="name")
     */
    protected $name;
    
    /**
     * @ORM\Column(length=255,name="info")
     */
    protected $info;
    
    /**
     * @ORM\Column(length=255,name="key_address")
     */
    protected $keyAddress;

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
    public function __construct(ServiceOrg $serviceOrg)
    {
        $this->parads = new \Doctrine\Common\Collections\ArrayCollection();
        $this->serviceOrg = $serviceOrg;
    }
    
    /**
     * toString
     */
    public function __toString()
    {
        $name = $this->getServiceOrg()->getName().' '.$this->name;
        return $name;
    }
    
    /**
     * Set name
     *
     * @param string $name
     * @return ServiceOrg
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
     * Set info
     *
     * @param string $info
     * @return ServiceOrg
     */
    public function setInfo($info)
    {
        $this->info = $info;
    
        return $this;
    }

    /**
     * Get info
     *
     * @return string 
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Add parads
     *
     * @param \Crm\AddressesBundle\Entity\Parad $parads
     * @return ServiceOrg
     */
    public function addParad(\Crm\AddressesBundle\Entity\Parad $parads)
    {
        $this->parads[] = $parads;
    
        return $this;
    }

    /**
     * Remove parads
     *
     * @param \Crm\AddressesBundle\Entity\Parad $parads
     */
    public function removeParad(\Crm\AddressesBundle\Entity\Parad $parads)
    {
        $this->parads->removeElement($parads);
    }

    /**
     * Get parads
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getParads()
    {
        return $this->parads;
    }

    /**
     * Set serviceOrg
     *
     * @param \Crm\AddressesBundle\Entity\ServiceOrg $serviceOrg
     * @return ServiceOrgDep
     */
    public function setServiceOrg(\Crm\AddressesBundle\Entity\ServiceOrg $serviceOrg = null)
    {
        $this->serviceOrg = $serviceOrg;
    
        return $this;
    }

    /**
     * Get serviceOrg
     *
     * @return \Crm\AddressesBundle\Entity\ServiceOrg 
     */
    public function getServiceOrg()
    {
        return $this->serviceOrg;
    }

    /**
     * Set keyAddress
     *
     * @param string $keyAddress
     * @return ServiceOrgDep
     */
    public function setKeyAddress($keyAddress)
    {
        $this->keyAddress = $keyAddress;
    
        return $this;
    }

    /**
     * Get keyAddress
     *
     * @return string 
     */
    public function getKeyAddress()
    {
        return $this->keyAddress;
    }
}