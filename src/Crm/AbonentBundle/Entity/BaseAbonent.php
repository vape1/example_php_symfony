<?php

namespace Crm\AbonentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Abonent
 *
 * @ORM\Table(name="abonent_base_abonent")
 * @ORM\Entity
 */
class BaseAbonent
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
     * @ORM\OneToOne(targetEntity="Crm\AbonentBundle\Entity\Appl", mappedBy="abonent", cascade={"persist"}, orphanRemoval=true)
     * @ORM\JoinColumn(name="appl_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $appl;
    
    /**
     * @ORM\OneToOne(targetEntity="Crm\AbonentBundle\Entity\AbonentPh", mappedBy="abonent", cascade={"persist"}, orphanRemoval=true)
     * @ORM\JoinColumn(name="abon_ph_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $abonentPh;
    
    /**
     * @ORM\OneToOne(targetEntity="Crm\AbonentBundle\Entity\AbonentPr", mappedBy="abonent")
     * @ORM\JoinColumn(name="abon_pr_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $abonentPr;
    
    /**
     * @ORM\Column(name="balance",type="float")
     */
    protected $balance;
    
    /**
     * @ORM\Column(name="archive",type="boolean")
     */
    protected $archive;
    
     /**
     * @ORM\Column(name="num_dogovor",type="string")
     */
    protected $numDogovor;
    
    /**
     * @ORM\Column(name="status",type="integer")
     */
    protected $status;
    
     /**
     * @ORM\OneToOne(targetEntity="Crm\AbonentBundle\Entity\StatisticInfo", mappedBy="abonent", cascade={"persist"})
     */
    protected $statisticInfo;
    
    /**
     * @ORM\OneToOne(targetEntity="Crm\AbonentBundle\Entity\OffInfo", mappedBy="abonent", cascade={"persist"})
     */
    protected $offInfo;
    
    /**
     * @ORM\Column(length=255,name="phone_cont",nullable=true)
     */
    protected $phoneCont;
    
    /**
     * @ORM\OneToMany(targetEntity="Crm\AbonentBundle\Entity\Call\Support", mappedBy="abonent", cascade={"persist"})
     * @ORM\OrderBy({"dateCall" = "DESC"})
     */
    protected $calls;
    
    /**
     * @ORM\Column(length=255,name="email",nullable=true)
     */
    protected $email;
    
    /**
     * @ORM\Column(length=255,name="name")
     */
    protected $name;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $lang;
    
    /**
     * Constructor
     */
    public function __construct(\Crm\AbonentBundle\Entity\AbonentInterface $abonent)
    {
        if($abonent instanceof \Crm\AbonentBundle\Entity\AbonentPh )
        {
            $this->setAbonentPh($abonent);
        }
        
        $this->status = 0;
        $this->balance = 0;
        $this->archive = 0;
        $this->lang = 1;
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
     * Get abonent
     *
     * @return integer 
     */
    public function getAbonent()
    {
        return $this->getAbonentPh()?:$this->getAbonentPr()?:null;
    }

    /**
     * Set balance
     *
     * @param float $balance
     * @return BaseAbonent
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
    
        return $this;
    }

    /**
     * Get balance
     *
     * @return float 
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * Set archive
     *
     * @param boolean $archive
     * @return BaseAbonent
     */
    public function setArchive($archive)
    {
        $this->archive = $archive;
    
        return $this;
    }

    /**
     * Get archive
     *
     * @return boolean 
     */
    public function getArchive()
    {
        return $this->archive;
    }

    /**
     * Set numDogovor
     *
     * @param integer $numDogovor
     * @return BaseAbonent
     */
    public function setNumDogovor($numDogovor)
    {
        $this->numDogovor = $numDogovor;
    
        return $this;
    }

    /**
     * Get numDogovor
     *
     * @return integer 
     */
    public function getNumDogovor()
    {
        return $this->numDogovor;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return BaseAbonent
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set abonentFiz
     *
     * @param \Crm\AbonentBundle\Entity\AbonentPh $abonentFiz
     * @return BaseAbonent
     */
    public function setAbonentPh(\Crm\AbonentBundle\Entity\AbonentPh $abonentPh = null)
    {
        $this->abonentPh = $abonentPh;
    
        return $this;
    }

    /**
     * Get abonentPh
     *
     * @return \Crm\AbonentBundle\Entity\AbonentPh 
     */
    public function getAbonentPh()
    {
        return $this->abonentPh;
    }

    /**
     * Set abonentPr
     *
     * @param \Crm\AbonentBundle\Entity\AbonentPr $abonentPr
     * @return BaseAbonent
     */
    public function setAbonentPr(\Crm\AbonentBundle\Entity\AbonentPr $abonentPr = null)
    {
        $this->abonentPr = $abonentPr;
    
        return $this;
    }

    /**
     * Get abonentPr
     *
     * @return \Crm\AbonentBundle\Entity\AbonentPr 
     */
    public function getAbonentPr()
    {
        return $this->abonentPr;
    }

    /**
     * Set statisticInfo
     *
     * @param \Crm\AbonentBundle\Entity\StatisticInfo $statisticInfo
     * @return BaseAbonent
     */
    public function setStatisticInfo(\Crm\AbonentBundle\Entity\StatisticInfo $statisticInfo = null)
    {
        $this->statisticInfo = $statisticInfo;
    
        return $this;
    }

    /**
     * Get statisticInfo
     *
     * @return \Crm\AbonentBundle\Entity\StatisticInfo 
     */
    public function getStatisticInfo()
    {
        return $this->statisticInfo;
    }

    /**
     * Set offInfo
     *
     * @param \Crm\AbonentBundle\Entity\OffInfo $offInfo
     * @return BaseAbonent
     */
    public function setOffInfo(\Crm\AbonentBundle\Entity\OffInfo $offInfo = null)
    {
        $this->offInfo = $offInfo;
    
        return $this;
    }

    /**
     * Get offInfo
     *
     * @return \Crm\AbonentBundle\Entity\OffInfo 
     */
    public function getOffInfo()
    {
        return $this->offInfo;
    }

    /**
     * Set phoneCont
     *
     * @param string $phoneCont
     * @return BaseAbonent
     */
    public function setPhoneCont($phoneCont)
    {
        $this->phoneCont = $phoneCont;
    
        return $this;
    }

    /**
     * Get phoneCont
     *
     * @return string 
     */
    public function getPhoneCont()
    {
        return $this->phoneCont;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return BaseAbonent
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return BaseAbonent
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
     * Set lang
     *
     * @param string $lang
     * @return BaseAbonent
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
    
        return $this;
    }

    /**
     * Get lang
     *
     * @return string 
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * Set appl
     *
     * @param \Crm\AbonentBundle\Entity\Appl $appl
     * @return BaseAbonent
     */
    public function setAppl(\Crm\AbonentBundle\Entity\Appl $appl = null)
    {
        $this->appl = $appl;
    
        return $this;
    }

    /**
     * Get appl
     *
     * @return \Crm\AbonentBundle\Entity\Appl 
     */
    public function getAppl()
    {
        return $this->appl;
    }

    /**
     * Add calls
     *
     * @param \Crm\AbonentBundle\Entity\Call\Support $calls
     * @return BaseAbonent
     */
    public function addCall(\Crm\AbonentBundle\Entity\Call\Support $calls)
    {
        $this->calls[] = $calls;
    
        return $this;
    }

    /**
     * Remove calls
     *
     * @param \Crm\AbonentBundle\Entity\Call\Support $calls
     */
    public function removeCall(\Crm\AbonentBundle\Entity\Call\Support $calls)
    {
        $this->calls->removeElement($calls);
    }

    /**
     * Get calls
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCalls()
    {
        return $this->calls;
    }
}