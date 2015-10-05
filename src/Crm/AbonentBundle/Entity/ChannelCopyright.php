<?php

namespace Crm\AbonentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ChannelCopyright
 *
 * @ORM\Table(name="channel_copyright")
 * @ORM\Entity
 */
class ChannelCopyright
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
     * @ORM\OneToMany(targetEntity="Crm\AbonentBundle\Entity\Channel", mappedBy="channel_copyright", cascade={"persist"})
     */
    protected $channels;
    
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


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
        $this->channels = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set name
     *
     * @param string $name
     * @return ChannelCopyright
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
     * Add channels
     *
     * @param \Crm\AbonentBundle\Entity\Channel $channels
     * @return ChannelCopyright
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