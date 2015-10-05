<?php

namespace Crm\AbonentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tarif
 *
 * @ORM\Table(name="service_tarif")
 * @ORM\Entity
 */
class Tarif
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
     * @ORM\OneToMany(targetEntity="Crm\AbonentBundle\Entity\Service", mappedBy="tarif", cascade={"persist"})
     */
    protected $services;
    
    /**
     * @ORM\Column(length=255,name="name")
     */
    protected $name;
    
    /**
     * @ORM\Column(length=255,name="politics",nullable=true)
     */
    protected $politics;


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
        $this->services = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set name
     *
     * @param string $name
     * @return Tarif
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
     * Set politics
     *
     * @param string $politics
     * @return Tarif
     */
    public function setPolitics($politics)
    {
        $this->politics = $politics;
    
        return $this;
    }

    /**
     * Get politics
     *
     * @return string 
     */
    public function getPolitics()
    {
        return $this->politics;
    }

    /**
     * Add services
     *
     * @param \Crm\AbonentBundle\Entity\Service $services
     * @return Tarif
     */
    public function addService(\Crm\AbonentBundle\Entity\Service $services)
    {
        $this->services[] = $services;
    
        return $this;
    }

    /**
     * Remove services
     *
     * @param \Crm\AbonentBundle\Entity\Service $services
     */
    public function removeService(\Crm\AbonentBundle\Entity\Service $services)
    {
        $this->services->removeElement($services);
    }

    /**
     * Get services
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getServices()
    {
        return $this->services;
    }
}