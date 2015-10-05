<?php

namespace Crm\AbonentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ChannelPack
 *
 * @ORM\Table(name="channel_pack_name")
 * @ORM\Entity
 */
class ChannelPack
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
     * @ORM\OneToMany(targetEntity="Crm\AbonentBundle\Entity\Service", mappedBy="channels_pack", cascade={"persist"})
     */
    protected $services;
    
    /**
     * @var Channel
     *
     * @ORM\ManyToMany(targetEntity="Crm\AbonentBundle\Entity\Channel", mappedBy="channels_pack")
     */
    protected $channels;
    
    /**
     * @ORM\Column(length=255,name="name")
     */
    protected $name;
    
    /**
     * @ORM\Column(length=255,name="descr")
     */
    protected $descr;

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
        $this->channels = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set name
     *
     * @param string $name
     * @return ChannelPack
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
     * Set descr
     *
     * @param string $descr
     * @return ChannelPack
     */
    public function setDescr($descr)
    {
        $this->descr = $descr;
    
        return $this;
    }

    /**
     * Get descr
     *
     * @return string 
     */
    public function getDescr()
    {
        return $this->descr;
    }

    /**
     * Add services
     *
     * @param \Crm\AbonentBundle\Entity\Service $services
     * @return ChannelPack
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

    /**
     * Add channels
     *
     * @param \Crm\AbonentBundle\Entity\Channel $channels
     * @return ChannelPack
     */
    public function addChannel(\Crm\AbonentBundle\Entity\Channel $channels)
    {
        $this->channels[] = $channels;
    
        return $this;
    }

    /**
     * Remove channels
     *
     * @param \Crm\AbonentBundle\Entity\Channel $channels
     */
    public function removeChannel(\Crm\AbonentBundle\Entity\Channel $channels)
    {
        $this->channels->removeElement($channels);
    }

    /**
     * Get channels
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChannels()
    {
        return $this->channels;
    }
}