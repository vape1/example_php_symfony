<?php

namespace Crm\AbonentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Appl
 *
 * @ORM\Table(name="abonent_appl")
 * @ORM\Entity(repositoryClass="Crm\AbonentBundle\Repository\ApplRepository")
 */
class Appl
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
     * @ORM\OneToOne(targetEntity="Crm\AbonentBundle\Entity\BaseAbonent", inversedBy="appl",cascade={"persist"}, orphanRemoval=true)
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $abonent;
    
    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="date_call",type="datetime")
     */
    protected $date_call;
    
    /**
     * @ORM\Column(name="date_conn",type="datetime",nullable=true)
     */
    protected $date_conn;
    
    /**
     * @ORM\Column(type="boolean",name="dogovor_mont")
     */
    protected $dogovor_mont;
    
    /**
     * @ORM\Column(type="boolean",name="pasp_mont")
     */
    protected $pasp_mont;
    
    /**
     * @ORM\Column(type="boolean",name="net_card")
     */
    protected $net_card;
    
    /**
     * @ORM\ManyToOne(targetEntity="Crm\AddressesBundle\Entity\Rival", inversedBy="appl")
     * @ORM\JoinColumn(name="rival_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $rival;
    
    /**
     * @ORM\ManyToOne(targetEntity="Crm\AbonentBundle\Entity\Reason", inversedBy="appl")
     * @ORM\JoinColumn(name="reason_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $reason;
    
    /**
     * @ORM\ManyToOne(targetEntity="Crm\AbonentBundle\Entity\HowFind", inversedBy="appl")
     * @ORM\JoinColumn(name="how_find_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $how_find;
    
    /**
     * @ORM\ManyToOne(targetEntity="Zk\UserBundle\Entity\User", inversedBy="appl")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;
    
    /**
     * @ORM\Column(type="text",name="note",nullable=true)
     */
    protected $note;
    
    /**
     * @ORM\Column(name="date_off",type="datetime",nullable=true)
     */
    protected $date_off;
    
    /**
     * @ORM\Column(name="who_off",type="datetime",nullable=true)
     */
    protected $who_off;
    
    /**
     * @ORM\Column(type="text",name="log",nullable=true)
     */
    protected $log;
    
    /**
     * Constructor
     */
    public function __construct(\Crm\AbonentBundle\Entity\BaseAbonent $abonent, \Zk\UserBundle\Entity\User $user)
    {
        $this->setAbonent($abonent);
        $this->setUser($user);
        $this->net_card = true;
        $this->pasp_mont = false;
        $this->dogovor_mont = false;
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
     * Set date_call
     *
     * @param \DateTime $dateCall
     * @return Appl
     */
    public function setDateCall($dateCall)
    {
        $this->date_call = $dateCall;
    
        return $this;
    }

    /**
     * Get date_call
     *
     * @return \DateTime 
     */
    public function getDateCall()
    {
        return $this->date_call;
    }

    /**
     * Set date_conn
     *
     * @param \DateTime $dateConn
     * @return Appl
     */
    public function setDateConn($dateConn)
    {
        $this->date_conn = $dateConn;
    
        return $this;
    }

    /**
     * Get date_conn
     *
     * @return \DateTime 
     */
    public function getDateConn()
    {
        return $this->date_conn;
    }

    /**
     * Set dogovor_mont
     *
     * @param boolean $dogovorMont
     * @return Appl
     */
    public function setDogovorMont($dogovorMont)
    {
        $this->dogovor_mont = $dogovorMont;
    
        return $this;
    }

    /**
     * Get dogovor_mont
     *
     * @return boolean 
     */
    public function getDogovorMont()
    {
        return $this->dogovor_mont;
    }

    /**
     * Set pasp_mont
     *
     * @param boolean $paspMont
     * @return Appl
     */
    public function setPaspMont($paspMont)
    {
        $this->pasp_mont = $paspMont;
    
        return $this;
    }

    /**
     * Get pasp_mont
     *
     * @return boolean 
     */
    public function getPaspMont()
    {
        return $this->pasp_mont;
    }

    /**
     * Set net_card
     *
     * @param boolean $netCard
     * @return Appl
     */
    public function setNetCard($netCard)
    {
        $this->net_card = $netCard;
    
        return $this;
    }

    /**
     * Get net_card
     *
     * @return boolean 
     */
    public function getNetCard()
    {
        return $this->net_card;
    }

    /**
     * Set how_find
     *
     * @param integer $howFind
     * @return Appl
     */
    public function setHowFind($howFind)
    {
        $this->how_find = $howFind;
    
        return $this;
    }

    /**
     * Get how_find
     *
     * @return integer 
     */
    public function getHowFind()
    {
        return $this->how_find;
    }

    /**
     * Set note
     *
     * @param string $note
     * @return Appl
     */
    public function setNote($note)
    {
        $this->note = $note;
    
        return $this;
    }

    /**
     * Get note
     *
     * @return string 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set date_off
     *
     * @param \DateTime $dateOff
     * @return Appl
     */
    public function setDateOff($dateOff)
    {
        $this->date_off = $dateOff;
    
        return $this;
    }

    /**
     * Get date_off
     *
     * @return \DateTime 
     */
    public function getDateOff()
    {
        return $this->date_off;
    }

    /**
     * Set who_off
     *
     * @param \DateTime $whoOff
     * @return Appl
     */
    public function setWhoOff($whoOff)
    {
        $this->who_off = $whoOff;
    
        return $this;
    }

    /**
     * Get who_off
     *
     * @return \DateTime 
     */
    public function getWhoOff()
    {
        return $this->who_off;
    }

    /**
     * Set abonent
     *
     * @param \Crm\AbonentBundle\Entity\BaseAbonent $abonent
     * @return Appl
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
     * @return Appl
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

    /**
     * Set reason
     *
     * @param \Crm\AbonentBundle\Entity\Reason $reason
     * @return Appl
     */
    public function setReason(\Crm\AbonentBundle\Entity\Reason $reason = null)
    {
        $this->reason = $reason;
    
        return $this;
    }

    /**
     * Get reason
     *
     * @return \Crm\AbonentBundle\Entity\Reason 
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Set user
     *
     * @param \Zk\UserBundle\Entity\User $user
     * @return Appl
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
     * Set log
     *
     * @param string $log
     * @return Appl
     */
    public function setLog($log)
    {
        $this->log = $log;
    
        return $this;
    }

    /**
     * Get log
     *
     * @return string 
     */
    public function getLog()
    {
        return $this->log;
    }
}