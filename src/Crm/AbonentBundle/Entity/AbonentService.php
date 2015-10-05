<?php

namespace Crm\AbonentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AbonentService
 *
 * @ORM\Table(name="abonent_service")
 * @ORM\Entity
 */
class AbonentService
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
     * @ORM\OneToOne(targetEntity="Crm\AbonentBundle\Entity\AbonentPh", inversedBy="service")
     * @ORM\JoinColumn(name="abonent_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $abonent;
    
    /**
     * @ORM\ManyToOne(targetEntity="Crm\AbonentBundle\Entity\Service", inversedBy="abonent_services")
     * @ORM\JoinColumn(name="service_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $service;

    /**
     * Constructor
     */
    public function __construct(\Crm\AbonentBundle\Entity\AbonentInterface $abonent)
    {
        $this->setAbonent($abonent);
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
     * Set abonent
     *
     * @param \Crm\AbonentBundle\Entity\AbonentPh $abonent
     * @return AbonentService
     */
    public function setAbonent(\Crm\AbonentBundle\Entity\AbonentPh $abonent = null)
    {
        $this->abonent = $abonent;
    
        return $this;
    }

    /**
     * Get abonent
     *
     * @return \Crm\AbonentBundle\Entity\AbonentPh 
     */
    public function getAbonent()
    {
        return $this->abonent;
    }

    /**
     * Set service
     *
     * @param \Crm\AbonentBundle\Entity\Service $service
     * @return AbonentService
     */
    public function setService(\Crm\AbonentBundle\Entity\Service $service = null)
    {
        $this->service = $service;
    
        return $this;
    }
    
    /**
     * Get service
     *
     * @return \Crm\AbonentBundle\Entity\Service 
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Get service
     *
     */
    public function getName()
    {
        return $this->getService()->getName();
    }
    
    /**
     * Get service
     *
     */
    public function getPackName()
    {
        return $this->getService()->getChannelsPack()->getName();
    }
}