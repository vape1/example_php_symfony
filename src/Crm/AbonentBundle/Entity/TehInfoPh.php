<?php

namespace Crm\AbonentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TehInfoFiz
 *
 * @ORM\Table(name="abonent_teh_info_fiz")
 * @ORM\Entity
 */
class TehInfoPh
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
     * @ORM\OneToOne(targetEntity="Crm\AbonentBundle\Entity\AbonentPh", inversedBy="tehInfo")
     * @ORM\JoinColumn(name="abonent_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $abonent;


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
     * @return TehInfoPh
     */
    public function setAbonent(\Crm\AbonentBundle\Entity\AbonentPh $abonent = null)
    {
        $this->abonent = $abonent;
    
        return $this;
    }

    /**
     * Get abonent
     *
     * @return \Crm\AbonentBundle\Entity\AbonentFiz 
     */
    public function getAbonent()
    {
        return $this->abonent;
    }
}