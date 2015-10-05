<?php
namespace Crm\AbonentBundle\Entity\Call;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

use Crm\AbonentBundle\Entity\Call\CallMethod;
use Crm\AbonentBundle\Entity\Call\CallSubCategory;
use Crm\AbonentBundle\Entity\Abonent;
use Zk\UserBundle\Entity\User;
use Crm\AbonentBundle\Entity\Call\CallAttach;
use Crm\AbonentBundle\CrmAbonentBundle;

/**
 * Support
 *
 * @ORM\Table(name="call_abonent")
 * @ORM\Entity(repositoryClass="Crm\AbonentBundle\Repository\SupportRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Support
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Crm\AbonentBundle\Entity\BaseAbonent", inversedBy="calls")
     * @ORM\JoinColumn(name="abonent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $abonent;

    /**
     * @ORM\ManyToOne(targetEntity="Crm\AbonentBundle\Entity\Call\CallMethod")
     * @ORM\JoinColumn(name="method_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $method;

    /**
     * @ORM\ManyToOne(targetEntity="Crm\AbonentBundle\Entity\Call\CallSubCategory")
     * @ORM\JoinColumn(name="sub_cat_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $subcategory;

    /**
     * @ORM\ManyToOne(targetEntity="Zk\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="open_user", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $openUser;

    /**
     * @ORM\ManyToOne(targetEntity="Zk\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="close_user", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $closeUser;

    /**
     * @ORM\ManyToOne(targetEntity="Zk\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="resp_user", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $respUser;

    /**
     * @ORM\OneToMany(targetEntity="Crm\AbonentBundle\Entity\Call\CallAttach", mappedBy="call", cascade={"persist", "remove", "merge"})
     */
    protected $attachments;
    
    /**
     * @ORM\Column(type="boolean")
     */
    protected $support;
    
    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="date_call",type="datetime")
     */
    protected $dateCall;

    /**
     * @ORM\Column(name="date_open",type="datetime", nullable=true)
     */
    protected $dateOpen;

    /**
     * @ORM\Column(name="date_close",type="datetime", nullable=true)
     */
    protected $dateClose;

    /**
     * @ORM\Column(length=1000)
     */
    protected $quest;

    /**
     * @ORM\Column(length=1000, nullable=true)
     */
    protected $answer;
    
    /**
     * @ORM\Column(length=255, nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(length=255, nullable=true)
     */
    protected $contacts;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $log;
    
    /**
     * @ORM\Column(name="is_close",type="boolean")
     */
    protected $isClose;

    /**
     * @var $old_values
     */
    protected $old_values=null;

    /**
     * @var $comment
     */
    protected $comment;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->attachments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dateCall = new \DateTime();
        $this->support = false;
        $this->isClose = false;
        if( $user = $this->getCurrentUser() )
        {
            $this->dateOpen = new \DateTime();
            $this->openUser = $user;
            $this->respUser = $user;
        }
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
     * Set support
     *
     * @param boolean $support
     * @return Support
     */
    public function setSupport($support)
    {
        $this->support = $support;
    
        return $this;
    }

    /**
     * Get support
     *
     * @return boolean 
     */
    public function getSupport()
    {
        return $this->support;
    }

    /**
     * Set dateCall
     *
     * @param \DateTime $dateCall
     * @return Support
     */
    public function setDateCall($dateCall)
    {
        $this->dateCall = $dateCall;
    
        return $this;
    }

    /**
     * Get dateCall
     *
     * @return \DateTime 
     */
    public function getDateCall()
    {
        return $this->dateCall;
    }

    /**
     * Set dateOpen
     *
     * @param \DateTime $dateOpen
     * @return Support
     */
    public function setDateOpen($dateOpen)
    {
        $this->dateOpen = $dateOpen;
    
        return $this;
    }

    /**
     * Get dateOpen
     *
     * @return \DateTime 
     */
    public function getDateOpen()
    {
        return $this->dateOpen;
    }

    /**
     * Set dateClose
     *
     * @param \DateTime $dateClose
     * @return Support
     */
    public function setDateClose($dateClose)
    {
        $this->dateClose = $dateClose;
    
        return $this;
    }

    /**
     * Get dateClose
     *
     * @return \DateTime 
     */
    public function getDateClose()
    {
        return $this->dateClose;
    }

    /**
     * Set quest
     *
     * @param string $quest
     * @return Support
     */
    public function setQuest($quest)
    {
        $this->quest = $quest;
    
        return $this;
    }

    /**
     * Get quest
     *
     * @return string 
     */
    public function getQuest()
    {
        return $this->quest;
    }

    /**
     * Set answer
     *
     * @param string $answer
     * @return Support
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
    
        return $this;
    }

    /**
     * Get answer
     *
     * @return string 
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Support
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
     * Set contacts
     *
     * @param string $contacts
     * @return Support
     */
    public function setContacts($contacts)
    {
        $this->contacts = $contacts;
    
        return $this;
    }

    /**
     * Get contacts
     *
     * @return string 
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * Set log
     *
     * @param string $log
     * @return Support
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

    /**
     * Set isClose
     *
     * @param boolean $isClose
     * @return Support
     */
    public function setIsClose($isClose)
    {
        if( $isClose and !$this->isClose ) $this->setDateClose( new \DateTime );
        $this->isClose = $isClose;
    
        return $this;
    }

    /**
     * Get isClose
     *
     * @return boolean 
     */
    public function getIsClose()
    {
        return $this->isClose;
    }

    /**
     * Set abonent
     *
     * @param \Crm\AbonentBundle\Entity\BaseAbonent $abonent
     * @return Support
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
     * Set method
     *
     * @param \Crm\AbonentBundle\Entity\Call\CallMethod $method
     * @return Support
     */
    public function setMethod(\Crm\AbonentBundle\Entity\Call\CallMethod $method = null)
    {
        $this->method = $method;
    
        return $this;
    }

    /**
     * Get method
     *
     * @return \Crm\AbonentBundle\Entity\Call\CallMethod 
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set subcategory
     *
     * @param \Crm\AbonentBundle\Entity\Call\CallSubCategory $subcategory
     * @return Support
     */
    public function setSubcategory(\Crm\AbonentBundle\Entity\Call\CallSubCategory $subcategory = null)
    {
        $this->subcategory = $subcategory;
    
        return $this;
    }

    /**
     * Get subcategory
     *
     * @return \Crm\AbonentBundle\Entity\Call\CallSubCategory 
     */
    public function getSubcategory()
    {
        return $this->subcategory;
    }

    /**
     * Set openUser
     *
     * @param \Zk\UserBundle\Entity\User $openUser
     * @return Support
     */
    public function setOpenUser(\Zk\UserBundle\Entity\User $openUser = null)
    {
        $this->openUser = $openUser;
    
        return $this;
    }

    /**
     * Get openUser
     *
     * @return \Zk\UserBundle\Entity\User 
     */
    public function getOpenUser()
    {
        return $this->openUser;
    }

    /**
     * Set closeUser
     *
     * @param \Zk\UserBundle\Entity\User $closeUser
     * @return Support
     */
    public function setCloseUser(\Zk\UserBundle\Entity\User $closeUser = null)
    {
        $this->closeUser = $closeUser;
    
        return $this;
    }

    /**
     * Get closeUser
     *
     * @return \Zk\UserBundle\Entity\User 
     */
    public function getCloseUser()
    {
        return $this->closeUser;
    }

    /**
     * Set respUser
     *
     * @param \Zk\UserBundle\Entity\User $respUser
     * @return Support
     */
    public function setRespUser(\Zk\UserBundle\Entity\User $respUser = null)
    {
        $this->respUser = $respUser;
    
        return $this;
    }

    /**
     * Get respUser
     *
     * @return \Zk\UserBundle\Entity\User 
     */
    public function getRespUser()
    {
        return $this->respUser;
    }

    /**
     * Add attachments
     *
     * @param \Crm\AbonentBundle\Entity\Call\CallAttach $attachments
     * @return Support
     */
    public function addAttachment(\Crm\AbonentBundle\Entity\Call\CallAttach $attachments)
    {
        $this->attachments[] = $attachments;
    
        return $this;
    }

    /**
     * Remove attachments
     *
     * @param \Crm\AbonentBundle\Entity\Call\CallAttach $attachments
     */
    public function removeAttachment(\Crm\AbonentBundle\Entity\Call\CallAttach $attachments)
    {
        $this->attachments->removeElement($attachments);
    }

    /**
     * Get attachments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAttachments()
    {
        return $this->attachments;
    }
    
    /**
     * Current user
     *
     * @return ArrayCollection A Doctrine ArrayCollection
     */
    public function getCurrentUser()
    {
        $token = CrmAbonentBundle::getContainer()->get('security.context')->getToken();
        
        if( $token and $token->getUser() instanceof \Zk\UserBundle\Entity\User)
        {
            return null !== $token->getUser() ? $token->getUser() : null;
        }
        
        return null;
    }
    
    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->abonent ? $this->abonent->getEmail() : null;
    }
    
    /**
     * Get respUserName
     *
     * @return string
     */
    public function getRespUserName()
    {
        return $this->respUser ? $this->respUser->getName() : null;
    }
    
    public function getEdit()
    {
        return 'Edit';
    }
    
    /**
     * Get id
     *
     * @return bigint 
     */
    public function initOldValues()
    {
        $this->old_values = clone $this;
    }
    
    /**
     * Set comment
     *
     * @param string $comment
     * @return Call
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
     
        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }
    
    /**
     * @ORM\PrePersist
     */
    public function myPrePersist()
    {
        if( $this->comment )
        {
            $name = $this->getCurrentUser()->getName();
            $date = date('Y-m-d H:i');
            $this->log .= sprintf("\n%s -- %s добавлен комментарий \n----------\n%s\n---------",
                $date,$name,$this->comment);
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function myPreUpdate()
    {
        if( $this->old_values )
        {
            $log = "";
            $date = date('Y-m-d H:i');
            $name = $this->getCurrentUser()->getName();
            
            if( $this->comment )
            {
                $log .= sprintf("\n%s -- %s добавлен комментарий \n----------\n%s\n---------",
                    $date,$name,$this->comment);
            }
            
            if( $this->old_values->method != $this->method )
            {
                $log .= sprintf("\n%s -- %s изменение способа обращения с %s на %s",
                    $date,$name,$this->old_values->method->getName(),$this->method->getName());
            }
            
            if( $this->old_values->subcategory != $this->subcategory )
            {
                $log .= sprintf("\n%s -- %s изменение категории обращения с %s на %s",
                    $date,$name,$this->old_values->subcategory->getName(),$this->subcategory->getName());
            }
            
            if( $this->old_values->name != $this->name )
            {
                $log .= sprintf("\n%s -- %s изменение имени обратившегося с %s на %s",
                    $date,$name,$this->old_values->name,$this->name);
            }
            
            if( $this->old_values->contacts != $this->contacts )
            {
                $log .= sprintf("\n%s -- %s изменение контактов обратившегося с %s на %s",
                    $date,$name,$this->old_values->contacts,$this->contacts);
            }
            
            if( $this->old_values->respUser != $this->respUser )
            {
                $log .= sprintf("\n%s -- %s изменение ответственного с %s на %s",
                    $date,$name,$this->old_values->respUser->getName(),$this->respUser->getName());
            }
            
            if( $this->old_values->support != $this->support )
            {
                $supp = $this->support ? 'Передано на Тех.Піддтрику' : 'Знято с Тех.Поіддтримки';
                $log .= sprintf("\n%s -- %s: %s",
                    $date,$name,$supp);
            }
            
            if( $this->old_values->isClose != $this->isClose )
            {
                if( $this->isClose )
                {
                    $close = 'Закрито';
                    $this->dateClose = new \DateTime();
                }
                else
                {
                    $close = 'Відкрито';
                    $this->dateClose = null;
                }
                $log .= sprintf("\n%s -- %s: %s",
                    $date,$name,$close);
            }
            
            if( $this->old_values->answer != $this->answer )
            {
                $log .= sprintf("\n%s -- %s зміна відповіді з %s на %s",
                    $date,$name,$this->old_values->answer,$this->answer);
            }
            
            if( $log ) $this->log .= trim($this->log) ? "\n".trim($log) : trim($log) ;
            
        }
    }
}