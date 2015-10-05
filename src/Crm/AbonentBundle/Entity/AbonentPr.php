<?php

namespace Crm\AbonentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AbonentPr
 *
 * @ORM\Table(name="abonent_abonent_pr")
 * @ORM\Entity(repositoryClass="Crm\AbonentBundle\Repository\AbonentPrRepository")
 */
class AbonentPr
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
     * @ORM\OneToOne(targetEntity="Crm\AbonentBundle\Entity\BaseAbonent", inversedBy="abonentPr",cascade={"persist"}, orphanRemoval=true)
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
     * @param \Crm\AbonentBundle\Entity\BaseAbonent $abonent
     * @return AbonentPr
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
}