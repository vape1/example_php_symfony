<?php

namespace Zk\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zk\UserBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * UserView
 *
 * @ORM\Table(name="fos_user_view")
 * @ORM\Entity(repositoryClass="Zk\UserBundle\Repository\UserViewRepository")
 */
class UserView
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
     * @ORM\ManyToOne(targetEntity="Zk\UserBundle\Entity\User", inversedBy="userViews")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;
    
    /**
     * @ORM\Column(length=64)
     */
    protected $name;
    
    /**
     * @ORM\Column(length=64)
     */
    protected $module;
    
    /**
     * @ORM\Column(type="array",nullable=true)
     */
    protected $config;

    
    /**
     * __construct
     *
     * @param string $name
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    
    /**                                                                                                                                                        
     * @Assert\True(message = "Повинно бути вибрано хоча б одне поле для відображення!")                                                                    
     */ 
    public function isEmptyConfig()  
    {
        foreach($this->getConfig() as $conf)
        {
            if(empty($conf)) return false;
        }
    }
    
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
     * @return UserView
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
     * Set module
     *
     * @param string $module
     * @return UserView
     */
    public function setModule($module)
    {
        $this->module = $module;
    
        return $this;
    }

    /**
     * Get module
     *
     * @return string 
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * Set user
     *
     * @param \Zk\UserBundle\Entity\User $user
     * @return UserView
     */
    public function setUser(\Zk\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Zk\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set config
     *
     * @param array $config
     * @return UserView
     */
    public function setConfig($config)
    {
        $this->config = $config;
    
        return $this;
    }

    /**
     * Get config
     *
     * @return array 
     */
    public function getConfig()
    {
        return $this->config;
    }
}