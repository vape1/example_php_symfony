<?php

namespace Crm\AbonentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OffInfo
 *
 * @ORM\Table(name="abonent_off_info")
 * @ORM\Entity
 */
class OffInfo
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
     * @ORM\OneToOne(targetEntity="Crm\AbonentBundle\Entity\BaseAbonent", inversedBy="offInfo")
     * @ORM\JoinColumn(name="abonent_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $abonent;
    
    /**
     * @ORM\Column(name="date_off",type="datetime")
     */
    protected $dateOff;
    
    /**
     * @ORM\Column(name="cat_off",type="integer")
     */
    protected $catOff;
    
    /**
     * @ORM\Column(name="why_off",type="text")
     */
    protected $whyOff;
    
    /**
     * @ORM\ManyToOne(targetEntity="Crm\AddressesBundle\Entity\Rival", inversedBy="offInfo")
     * @ORM\JoinColumn(name="rival_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $rival;


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
     * Set dateOff
     *
     * @param \DateTime $dateOff
     * @return OffInfo
     */
    public function setDateOff($dateOff)
    {
        $this->dateOff = $dateOff;
    
        return $this;
    }

    /**
     * Get dateOff
     *
     * @return \DateTime 
     */
    public function getDateOff()
    {
        return $this->dateOff;
    }

    /**
     * Set catOff
     *
     * @param integer $catOff
     * @return OffInfo
     */
    public function setCatOff($catOff)
    {
        $this->catOff = $catOff;
    
        return $this;
    }

    /**
     * Get catOff
     *
     * @return integer 
     */
    public function getCatOff()
    {
        return $this->catOff;
    }

    /**
     * Set whyOff
     *
     * @param string $whyOff
     * @return OffInfo
     */
    public function setWhyOff($whyOff)
    {
        $this->whyOff = $whyOff;
    
        return $this;
    }

    /**
     * Get whyOff
     *
     * @return string 
     */
    public function getWhyOff()
    {
        return $this->whyOff;
    }

    /**
     * Set abonent
     *
     * @param \Crm\AbonentBundle\Entity\BaseAbonent $abonent
     * @return OffInfo
     */
    public function setAbonent(\Crm\AbonentBundle\Entity\BaseAbonent $abonent = null)
    {
        $this->abonent = $abonent;
    
        return $this;
    }

    /**
     * Get abonent
     *
     * @return \Crm\AbonentBundle\Entity\BaseAbonent 
     */
    public function getAbonent()
    {
        return $this->abonent;
    }

    /**
     * Set rival
     *
     * @param \Crm\AddressesBundle\Entity\Rival $rival
     * @return OffInfo
     */
    public function setRival(\Crm\AddressesBundle\Entity\Rival $rival = null)
    {
        $this->rival = $rival;
    
        return $this;
    }

    /**
     * Get rival
     *
     * @return \Crm\AddressesBundle\Entity\Rival 
     */
    public function getRival()
    {
        return $this->rival;
    }
}