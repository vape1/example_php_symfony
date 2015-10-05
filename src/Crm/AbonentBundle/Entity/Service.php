<?php

namespace Crm\AbonentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Service
 *
 * @ORM\Table(name="service_service")
 * @ORM\Entity
 */
class Service
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
     * @ORM\OneToMany(targetEntity="Crm\AbonentBundle\Entity\AbonentService", mappedBy="service", cascade={"persist"})
     */
    protected $abonent_services;
    
    /**
     * @ORM\ManyToOne(targetEntity="Crm\AbonentBundle\Entity\Tarif", inversedBy="services")
     * @ORM\JoinColumn(name="tar_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $tarif;
    
    /**
     * @ORM\ManyToOne(targetEntity="Crm\AbonentBundle\Entity\ChannelPack", inversedBy="services")
     * @ORM\JoinColumn(name="channels_pack_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $channels_pack;
    
    /**
     * @ORM\Column(type="float",name="cost")
     */
    protected $cost;
    
    /**
     * @ORM\Column(length=255,name="name")
     */
    protected $name;
    
    /**
     * @ORM\Column(type="integer",name="type")
     */
    protected $type;

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
     * __toString
     */
    public function __toString()
    {
        return $this->getName();
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->abonent_services = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set cost
     *
     * @param float $cost
     * @return Service
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    
        return $this;
    }

    /**
     * Get cost
     *
     * @return float 
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Service
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
     * Set type
     *
     * @param integer $type
     * @return Service
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add abonent_services
     *
     * @param \Crm\AbonentBundle\Entity\AbonentService $abonentServices
     * @return Service
     */
    public function addAbonentService(\Crm\AbonentBundle\Entity\AbonentService $abonentServices)
    {
        $this->abonent_services[] = $abonentServices;
    
        return $this;
    }

    /**
     * Remove abonent_services
     *
     * @param \Crm\AbonentBundle\Entity\AbonentService $abonentServices
     */
    public function removeAbonentService(\Crm\AbonentBundle\Entity\AbonentService $abonentServices)
    {
        $this->abonent_services->removeElement($abonentServices);
    }

    /**
     * Get abonent_services
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAbonentServices()
    {
        return $this->abonent_services;
    }

    /**
     * Set tarif
     *
     * @param \Crm\AbonentBundle\Entity\Tarif $tarif
     * @return Service
     */
    public function setTarif(\Crm\AbonentBundle\Entity\Tarif $tarif = null)
    {
        $this->tarif = $tarif;
    
        return $this;
    }

    /**
     * Get tarif
     *
     * @return \Crm\AbonentBundle\Entity\Tarif 
     */
    public function getTarif()
    {
        return $this->tarif;
    }

    /**
     * Set channels_pack
     *
     * @param \Crm\AbonentBundle\Entity\ChannelPack $channelsPack
     * @return Service
     */
    public function setChannelsPack(\Crm\AbonentBundle\Entity\ChannelPack $channelsPack = null)
    {
        $this->channels_pack = $channelsPack;
    
        return $this;
    }

    /**
     * Get channels_pack
     *
     * @return \Crm\AbonentBundle\Entity\ChannelPack 
     */
    public function getChannelsPack()
    {
        return $this->channels_pack;
    }
}