<?php

namespace Crm\AbonentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactInfoFiz
 *
 * @ORM\Table(name="abonent_contact_info")
 * @ORM\Entity
 */
class ContactInfoPh
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
     * @ORM\OneToOne(targetEntity="Crm\AbonentBundle\Entity\AbonentPh", inversedBy="contactInfo")
     * @ORM\JoinColumn(name="abonent_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $abonent;
    
    /**
     * @ORM\Column(name="date_valid_email",type="datetime",nullable=true)
     */
    protected $dateValidEmail;
    
    /**
     * @ORM\Column(name="notify_email_one",type="boolean")
     */
    protected $notifyEmailOne;
    
    /**
     * @ORM\Column(name="notify_email_five",type="boolean")
     */
    protected $notifyEmailFive;
    
    /**
     * @ORM\Column(length=255,name="phone_mob",nullable=true)
     */
    protected $phoneMob;
    
    /**
     * @ORM\Column(length=255,name="phone_dom",nullable=true)
     */
    protected $phoneDom;
    
    /**
     * @ORM\Column(type="boolean",name="notify_phone")
     */
    protected $notifyPhone;
    
    /**
     * @ORM\Column(name="os",type="integer")
     */
    protected $os;
    
    /**
     * @ORM\Column(type="boolean",name="flag_dog")
     */
    protected $flagDog;
    
    /**
     * @ORM\Column(type="boolean",name="flag_pasp")
     */
    protected $flagPasp;
    
    /**
     * @ORM\Column(type="text",name="profil",nullable=true)
     */
    protected $profile;
    
    /**
     * @ORM\Column(name="birth_day",type="datetime",nullable=true)
     */
    protected $birthDay;
    
    /**
     * @ORM\Column(length=255,name="pasp_ser",nullable=true)
     */
    protected $pasp_ser;
    
    /**
     * @ORM\Column(length=255,name="pasp_num",nullable=true)
     */
    protected $pasp_num;
    
    /**
     * @ORM\Column(length=255,name="pasp_whom",nullable=true)
     */
    protected $pasp_whom;
    
    /**
     * @ORM\Column(length=255,name="pasp_ipn",nullable=true)
     */
    protected $pasp_ipn;
    
    /**
     * @ORM\Column(type="boolean",name="rent")
     */
    protected $rent;
    
    /**
     * Constructor
     */
    public function __construct(\Crm\AbonentBundle\Entity\AbonentInterface $abonent)
    {
        $this->setAbonent($abonent);
        $this->flagPasp = false;
        $this->flagDog = false;
        $this->notifyPhone = false;
        $this->notifyEmailFive = false;
        $this->notifyEmailOne = false;
        $this->rent = false;
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
     * Set notifyEmailOne
     *
     * @param boolean $notifyEmailOne
     * @return ContactInfoPh
     */
    public function setNotifyEmailOne($notifyEmailOne)
    {
        $this->notifyEmailOne = $notifyEmailOne;
    
        return $this;
    }

    /**
     * Get notifyEmailOne
     *
     * @return boolean 
     */
    public function getNotifyEmailOne()
    {
        return $this->notifyEmailOne;
    }

    /**
     * Set notifyEmailFive
     *
     * @param boolean $notifyEmailFive
     * @return ContactInfoPh
     */
    public function setNotifyEmailFive($notifyEmailFive)
    {
        $this->notifyEmailFive = $notifyEmailFive;
    
        return $this;
    }

    /**
     * Get notifyEmailFive
     *
     * @return boolean 
     */
    public function getNotifyEmailFive()
    {
        return $this->notifyEmailFive;
    }


    /**
     * Set phoneMob
     *
     * @param string $phoneMob
     * @return ContactInfoPh
     */
    public function setPhoneMob($phoneMob)
    {
        $this->phoneMob = $phoneMob;
    
        return $this;
    }

    /**
     * Get phoneMob
     *
     * @return string 
     */
    public function getPhoneMob()
    {
        return $this->phoneMob;
    }

    /**
     * Set phoneDom
     *
     * @param string $phoneDom
     * @return ContactInfoPh
     */
    public function setPhoneDom($phoneDom)
    {
        $this->phoneDom = $phoneDom;
    
        return $this;
    }

    /**
     * Get phoneDom
     *
     * @return string 
     */
    public function getPhoneDom()
    {
        return $this->phoneDom;
    }

    /**
     * Set notifyPhone
     *
     * @param boolean $notifyPhone
     * @return ContactInfoPh
     */
    public function setNotifyPhone($notifyPhone)
    {
        $this->notifyPhone = $notifyPhone;
    
        return $this;
    }

    /**
     * Get notifyPhone
     *
     * @return boolean 
     */
    public function getNotifyPhone()
    {
        return $this->notifyPhone;
    }

    /**
     * Set os
     *
     * @param integer $os
     * @return ContactInfoPh
     */
    public function setOs($os)
    {
        $this->os = $os;
    
        return $this;
    }

    /**
     * Get os
     *
     * @return integer 
     */
    public function getOs()
    {
        return $this->os;
    }

    /**
     * Set flagDog
     *
     * @param boolean $flagDog
     * @return ContactInfoPh
     */
    public function setFlagDog($flagDog)
    {
        $this->flagDog = $flagDog;
    
        return $this;
    }

    /**
     * Get flagDog
     *
     * @return boolean 
     */
    public function getFlagDog()
    {
        return $this->flagDog;
    }

    /**
     * Set flagPasp
     *
     * @param boolean $flagPasp
     * @return ContactInfoPh
     */
    public function setFlagPasp($flagPasp)
    {
        $this->flagPasp = $flagPasp;
    
        return $this;
    }

    /**
     * Get flagPasp
     *
     * @return boolean 
     */
    public function getFlagPasp()
    {
        return $this->flagPasp;
    }

    /**
     * Set profile
     *
     * @param string $profile
     * @return ContactInfoPh
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;
    
        return $this;
    }

    /**
     * Get profile
     *
     * @return string 
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Set abonent
     *
     * @param \Crm\AbonentBundle\Entity\AbonentPh $abonent
     * @return ContactInfoPh
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
     * Set birthDay
     *
     * @param \DateTime $birthDay
     * @return ContactInfoPh
     */
    public function setBirthDay($birthDay)
    {
        $this->birthDay = $birthDay;
    
        return $this;
    }

    /**
     * Get birthDay
     *
     * @return \DateTime 
     */
    public function getBirthDay()
    {
        return $this->birthDay;
    }
    

    /**
     * Set dateValidEmail
     *
     * @param \DateTime $dateValidEmail
     * @return ContactInfoPh
     */
    public function setDateValidEmail($dateValidEmail)
    {
        $this->dateValidEmail = $dateValidEmail;
    
        return $this;
    }

    /**
     * Get dateValidEmail
     *
     * @return \DateTime 
     */
    public function getDateValidEmail()
    {
        return $this->dateValidEmail;
    }

    /**
     * Set pasp_ser
     *
     * @param string $paspSer
     * @return ContactInfoPh
     */
    public function setPaspSer($paspSer)
    {
        $this->pasp_ser = $paspSer;
    
        return $this;
    }

    /**
     * Get pasp_ser
     *
     * @return string 
     */
    public function getPaspSer()
    {
        return $this->pasp_ser;
    }

    /**
     * Set pasp_num
     *
     * @param string $paspNum
     * @return ContactInfoPh
     */
    public function setPaspNum($paspNum)
    {
        $this->pasp_num = $paspNum;
    
        return $this;
    }

    /**
     * Get pasp_num
     *
     * @return string 
     */
    public function getPaspNum()
    {
        return $this->pasp_num;
    }

    /**
     * Set pasp_whom
     *
     * @param string $paspWhom
     * @return ContactInfoPh
     */
    public function setPaspWhom($paspWhom)
    {
        $this->pasp_whom = $paspWhom;
    
        return $this;
    }

    /**
     * Get pasp_whom
     *
     * @return string 
     */
    public function getPaspWhom()
    {
        return $this->pasp_whom;
    }

    /**
     * Set pasp_ipn
     *
     * @param string $paspIpn
     * @return ContactInfoPh
     */
    public function setPaspIpn($paspIpn)
    {
        $this->pasp_ipn = $paspIpn;
    
        return $this;
    }

    /**
     * Get pasp_ipn
     *
     * @return string 
     */
    public function getPaspIpn()
    {
        return $this->pasp_ipn;
    }
    
     /**
     * Set rent
     *
     * @param  $rent
     * @return boolean
     */
    public function setRent($rent)
    {
        $this->rent = $rent;
     
        return $this;
    }

    /**
     * Get rent
     *
     * @return integer
     */
    public function getRent()
    {
        return $this->rent;
    }
}