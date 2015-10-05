<?php

namespace Crm\AbonentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Crm\AbonentBundle\Entity\BaseAbonent;
use Crm\AbonentBundle\Entity\AbonentInterface;

/**
 * AbonentPh
 * @ORM\Table(name="abonent_abonent_ph")
 * @ORM\Entity(repositoryClass="Crm\AbonentBundle\Repository\AbonentPhRepository")AbonentPh
 */
class AbonentPh  implements AbonentInterface
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
     * @ORM\OneToOne(targetEntity="Crm\AbonentBundle\Entity\BaseAbonent", inversedBy="abonentPh",cascade={"persist"}, orphanRemoval=true)
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $abonent;
    
    /**
     * @ORM\Column(name="bonuce_balance",type="float")
     */
    protected $bonuceBalance;
    
    /**
     * @ORM\OneToOne(targetEntity="Crm\AbonentBundle\Entity\ContactInfoPh", mappedBy="abonent", cascade={"persist"})
     */
    protected $contactInfo;
    
    /**
     * @ORM\ManyToOne(targetEntity="Crm\AddressesBundle\Entity\Flat", inversedBy="abonents")
     * @ORM\JoinColumn(name="flat_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $flat;
    
    /**
     * @ORM\OneToOne(targetEntity="Crm\AbonentBundle\Entity\TehInfoPh", mappedBy="abonent", cascade={"persist"})
     */
    protected $tehInfo;
    
     /**
     * @ORM\OneToOne(targetEntity="Crm\AbonentBundle\Entity\AbonentService", mappedBy="abonent", cascade={"persist"})
     */
    protected $service;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->bonuceBalance = 0;
    }
    
    /**
     * __toString
     */
    public function __toString()
    {
        return $this->getName();
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
     * Set bonuceBalance
     *
     * @param float $bonuceBalance
     * @return AbonentPh
     */
    public function setBonuceBalance($bonuceBalance)
    {
        $this->bonuceBalance = $bonuceBalance;
    
        return $this;
    }

    /**
     * Get bonuceBalance
     *
     * @return float 
     */
    public function getBonuceBalance()
    {
        return $this->bonuceBalance;
    }

    /**
     * Set abonent
     *
     * @param \Crm\AbonentBundle\Entity\BaseAbonent $abonent
     * @return AbonentPh
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
     * Set contactInfo
     *
     * @param \Crm\AbonentBundle\Entity\ContactInfoPh $contactInfo
     * @return AbonentPh
     */
    public function setContactInfo(\Crm\AbonentBundle\Entity\ContactInfoPh $contactInfo = null)
    {
        $this->contactInfo = $contactInfo;
    
        return $this;
    }

    /**
     * Get contactInfo
     *
     * @return \Crm\AbonentBundle\Entity\ContactInfoPh 
     */
    public function getContactInfo()
    {
        return $this->contactInfo;
    }

    /**
     * Set tehInfo
     *
     * @param \Crm\AbonentBundle\Entity\TehInfoPh $tehInfo
     * @return AbonentPh
     */
    public function setTehInfo(\Crm\AbonentBundle\Entity\TehInfoPh $tehInfo = null)
    {
        $this->tehInfo = $tehInfo;
    
        return $this;
    }

    /**
     * Get tehInfo
     *
     * @return \Crm\AbonentBundle\Entity\TehInfoPh 
     */
    public function getTehInfo()
    {
        return $this->tehInfo;
    }
    
    /**
     * Get NumDogovor
     *
     * @return string
     */
    public function getNumDogovor()
    {
        return $this->getAbonent()->getNumDogovor();
    }
    
    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        if($this->getFlat())
        return $this->getFlat()->getAddress();
        return false;
    }
    
    /**
     * Get Balance
     *
     * @return float
     */
    public function getBalance()
    {
        return $this->getAbonent()->getBalance();
    }
    
    /**
     * Set phoneCont
     *
     * @param string $phoneCont
     * @return BaseAbonent
     */
    public function setPhoneCont($phoneCont)
    {
        $this->getAbonent()->setPhoneCont($phoneCont);
    
        return $this;
    }

    /**
     * Get phoneCont
     *
     * @return string 
     */
    public function getPhoneCont()
    {
        return $this->getAbonent()->getPhoneCont();
    }

    /**
     * Set email
     *
     * @param string $email
     * @return BaseAbonent
     */
    public function setEmail($email)
    {
        $this->getAbonent()->setEmail($email);
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->getAbonent()->getEmail();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return BaseAbonent
     */
    public function setName($name)
    {
        $this->getAbonent()->setName($name);
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->getAbonent()->getName();
    }
    
    /**
     * Set Firstname
     *
     * @param string $name
     * @return BaseAbonent
     */
    public function setFirstName($firstName)
    {
        $name = explode(' ',$this->getAbonent()->getName());
        if(!array_key_exists(1,$name)) return false;
        $name[1] = $firstName;
        $name = implode(' ',$name);
        $this->getAbonent()->setName($name);
    
        return $this;
    }

    /**
     * Get Firstname
     *
     * @return string 
     */
    public function getFirstName()
    {
        $name = explode(' ',$this->getAbonent()->getName());
        if(!array_key_exists(1,$name)) return false;
        return $name[1];
    }
    
    /**
     * Set Surname
     *
     * @param string $name
     * @return BaseAbonent
     */
    public function setSurname($surname)
    {
        $name = explode(' ',$this->getAbonent()->getName());
        $name[0] = $surname;
        $name = implode(' ',$name);
        $this->getAbonent()->setName($name);
     
        return $this;
    }

    /**
     * Get Surname
     *
     * @return string 
     */
    public function getSurname()
    {
        
        $name = explode(' ',$this->getAbonent()->getName());
        if(!array_key_exists(0,$name)) return false;
        return $name[0];
    }
    
    /**
     * Set name
     *
     * @param string $name
     * @return BaseAbonent
     */
    public function setFatherName($fatherName)
    {
        $name = explode(' ',$this->getAbonent()->getName());
        $name[2] = $fatherName;
        $name = implode(' ',$name);
        $this->getAbonent()->setName($name);
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getFatherName()
    {
        $name = explode(' ',$this->getAbonent()->getName());
        if(!array_key_exists(2,$name)) return false;
        return $name[2];
    }

    /**
     * Set lang
     *
     * @param string $lang
     * @return BaseAbonent
     */
    public function setLang($lang)
    {
        $this->getAbonent()->setLang($lang);
    
        return $this;
    }

    /**
     * Get lang
     *
     * @return string 
     */
    public function getLang()
    {
        return $this->getAbonent()->getLang();
    }
    
    /**
     * Get Appl
     *
     * @return string 
     */
    public function getAppl()
    {
        return $this->getAbonent()->getAppl();
    }
    
    /**
     * Set Appl
     *
     * @return string 
     */
    public function setAppl($appl)
    {
        return $this->getAbonent()->setAppl($appl);
    }

    /**
     * Set service
     *
     * @param \Crm\AbonentBundle\Entity\AbonentService $service
     * @return AbonentPh
     */
    public function setService(\Crm\AbonentBundle\Entity\AbonentService $service = null)
    {
        $this->service = $service;
    
        return $this;
    }

    /**
     * Get service
     *
     * @return \Crm\AbonentBundle\Entity\AbonentService 
     */
    public function getService()
    {
        return $this->service;
    }
    
    public function getClassName()
    {
        return 'abonentph';
    }

    /**
     * Set flat
     *
     * @param \Crm\AddressesBundle\Entity\Flat $flat
     * @return AbonentPh
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