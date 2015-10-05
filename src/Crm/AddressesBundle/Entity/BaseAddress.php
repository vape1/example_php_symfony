<?php

namespace Crm\AddressesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BaseAddress
 *
 */
abstract class BaseAddress
{
    /**
     * @ORM\Column(length=255,name="name_ru")
     */
    protected $nameRu;
    
    /**
     * @ORM\Column(length=255,name="name_ua")
     */
    protected $nameUa;

     /**
     * Set nameRu
     *
     * @param string $nameRu
     * @return $this
     */
    public function setNameRu($nameRu)
    {
        $this->nameRu = $nameRu;
    
        return $this;
    }

    /**
     * Get nameRu
     *
     * @return string 
     */
    public function getNameRu()
    {
        return $this->nameRu;
    }

    /**
     * Set nameUa
     *
     * @param string $nameUa
     * @return $this
     */
    public function setNameUa($nameUa)
    {
        $this->nameUa = $nameUa;
    
        return $this;
    }

    /**
     * Get nameUa
     *
     * @return string 
     */
    public function getNameUa()
    {
        return $this->nameUa;
    }
}
