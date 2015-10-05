<?php

namespace Crm\AddressesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ServiceOrg
 *
 * @ORM\Table(name="address_service_org")
 * @ORM\Entity
 */
class ServiceOrg
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
     * @ORM\OneToMany(targetEntity="Crm\AddressesBundle\Entity\ServiceOrgDep", mappedBy="serviceOrg", cascade={"persist"})
     */
    protected $serviceOrgDeps;

    /**
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @ORM\Column(length=255,name="eprasys_name")
     */
    protected $eprasysName;

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
     * Constructor
     */
    public function __construct()
    {
        $this->serviceOrgDeps = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add serviceOrgDeps
     *
     * @param \Crm\AddressesBundle\Entity\ServiceOrgDep $serviceOrgDeps
     * @return ServiceOrg
     */
    public function addServiceOrgDeps(\Crm\AddressesBundle\Entity\ServiceOrgDep $serviceOrgDeps)
    {
        $this->serviceOrgDeps[] = $serviceOrgDeps;
    
        return $this;
    }

    /**
     * Remove serviceOrgDeps
     *
     * @param \Crm\AddressesBundle\Entity\ServiceOrgDeps $serviceOrgDeps
     */
    public function removeServiceOrgDeps(\Crm\AddressesBundle\Entity\ServiceOrgDep $serviceOrgDeps)
    {
        $this->serviceOrgDeps->removeElement($serviceOrgDeps);
    }

    /**
     * Get serviceOrgDeps
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getServiceOrgDeps()
    {
        return $this->serviceOrgDeps;
    }
    
    public function getEdit()
    {
        return 'Edit';
    }

    /**
     * Set eprasysName
     *
     * @param string $eprasysName
     * @return ServiceOrg
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
     * Add serviceOrgDeps
     *
     * @param \Crm\AddressesBundle\Entity\ServiceOrgDep $serviceOrgDeps
     * @return ServiceOrg
     */
    public function addServiceOrgDep(\Crm\AddressesBundle\Entity\ServiceOrgDep $serviceOrgDeps)
    {
        $this->serviceOrgDeps[] = $serviceOrgDeps;
    
        return $this;
    }

    /**
     * Remove serviceOrgDeps
     *
     * @param \Crm\AddressesBundle\Entity\ServiceOrgDep $serviceOrgDeps
     */
    public function removeServiceOrgDep(\Crm\AddressesBundle\Entity\ServiceOrgDep $serviceOrgDeps)
    {
        $this->serviceOrgDeps->removeElement($serviceOrgDeps);
    }
}