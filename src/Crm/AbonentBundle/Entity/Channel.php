<?php

namespace Crm\AbonentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Channels
 *
 * @ORM\Table(name="channel_name")
 * @ORM\Entity
 */
class Channel
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * @var ChannelsPack
     *
     * @ORM\ManyToMany(targetEntity="Crm\AbonentBundle\Entity\ChannelPack", inversedBy="channels")
     * @ORM\JoinTable(name="channel_channel_pack",
     *   joinColumns={
     *     @ORM\JoinColumn(name="channel_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="pack_id", referencedColumnName="id")
     *   }
     * )
     */
    protected $channels_pack;
    
     /**
     * @ORM\ManyToOne(targetEntity="Crm\AbonentBundle\Entity\ChannelCopyright", inversedBy="channels")
     * @ORM\JoinColumn(name="copyright_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $channel_copyright;
    
    /**
     * @ORM\Column(type="integer",name="channel")
     */
    protected $channel;
    
    /**
     * @ORM\Column(type="text",name="descr")
     */
    protected $descr;

    /**
     * @ORM\Column(type="boolean",name="blocked")
     */
    protected $blocked;
    
    /**
     * @ORM\Column(type="boolean",name="flag")
     */
    protected $flag;
    
    /**
     * @ORM\Column(type="boolean",name="statistic")
     */
    protected $statistic;


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
     * @return Channels
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
        $this->channels_pack = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set channel
     *
     * @param integer $channel
     * @return Channel
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;
    
        return $this;
    }

    /**
     * Get channel
     *
     * @return integer 
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * Set descr
     *
     * @param string $descr
     * @return Channel
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
     * Set blocked
     *
     * @param boolean $blocked
     * @return Channel
     */
    public function setBlocked($blocked)
    {
        $this->blocked = $blocked;
    
        return $this;
    }

    /**
     * Get blocked
     *
     * @return boolean 
     */
    public function getBlocked()
    {
        return $this->blocked;
    }

    /**
     * Set flag
     *
     * @param boolean $flag
     * @return Channel
     */
    public function setFlag($flag)
    {
        $this->flag = $flag;
    
        return $this;
    }

    /**
     * Get flag
     *
     * @return boolean 
     */
    public function getFlag()
    {
        return $this->flag;
    }

    /**
     * Set statistic
     *
     * @param boolean $statistic
     * @return Channel
     */
    public function setStatistic($statistic)
    {
        $this->statistic = $statistic;
    
        return $this;
    }

    /**
     * Get statistic
     *
     * @return boolean 
     */
    public function getStatistic()
    {
        return $this->statistic;
    }

    /**
     * Add channels_pack
     *
     * @param \Crm\AbonentBundle\Entity\ChannelPack $channelsPack
     * @return Channel
     */
    public function addChannelsPack(\Crm\AbonentBundle\Entity\ChannelPack $channelsPack)
    {
        $this->channels_pack[] = $channelsPack;
    
        return $this;
    }

    /**
     * Remove channels_pack
     *
     * @param \Crm\AbonentBundle\Entity\ChannelPack $channelsPack
     */
    public function removeChannelsPack(\Crm\AbonentBundle\Entity\ChannelPack $channelsPack)
    {
        $this->channels_pack->removeElement($channelsPack);
    }

    /**
     * Get channels_pack
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChannelsPack()
    {
        return $this->channels_pack;
    }

    /**
     * Set channel_copyright
     *
     * @param \Crm\AbonentBundle\Entity\ChannelCopyright $channelCopyright
     * @return Channel
     */
    public function setChannelCopyright(\Crm\AbonentBundle\Entity\ChannelCopyright $channelCopyright = null)
    {
        $this->channel_copyright = $channelCopyright;
    
        return $this;
    }

    /**
     * Get channel_copyright
     *
     * @return \Crm\AbonentBundle\Entity\ChannelCopyright 
     */
    public function getChannelCopyright()
    {
        return $this->channel_copyright;
    }
}