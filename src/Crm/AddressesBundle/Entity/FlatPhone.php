<?php

namespace Crm\AddressesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FlatPhone
 *
 * @ORM\Table(name="address_flat_phone")
 * @ORM\Entity(repositoryClass="Crm\AddressesBundle\Repository\FlatPhoneRepository")
 */
class FlatPhone
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
     * @ORM\ManyToOne(targetEntity="Crm\AddressesBundle\Entity\Flat", inversedBy="flatPhones")
     * @ORM\JoinColumn(name="flat_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $flat;
    
    /**
     * @ORM\Column(length=255,name="descr")
     */
    protected $descr;
    
    /**
     * @ORM\Column(length=255,name="phone")
     */
    protected $phone;
    
    /**
     * @ORM\Column(type="boolean",name="status")
     */
    protected $status;
    
    /**
     * @ORM\Column(type="boolean",name="main")
     */
    protected $main;

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
     * Set flat
     *
     * @param \Crm\AddressesBundle\Entity\Flat $flat
     * @return FlatPhone
     */
    public function setFlat(\Crm\AddressesBundle\Entity\Flat $flat = null)
    {
        $this->flat = $flat;
     
        return $this;
    }

    /**
     * Get flat
     *
     * @return \Crm\AddressesBundle\Entity\Flat 
     */
    public function getFlat()
    {
        return $this->flat;
    }
}