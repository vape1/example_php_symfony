<?php
namespace Crm\AbonentBundle\Entity\Call;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
#use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="Crm\AbonentBundle\Repository\CallAttachRepository")
 * @ORM\Table(name="call_attach")
 * @ORM\HasLifecycleCallbacks()
 */
class CallAttach
{
    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Crm\AbonentBundle\Entity\Call\Support", inversedBy="attachments")
     * @ORM\JoinColumn(name="call_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $call;

    /**
     * @ORM\Column(length=255)
     */
    protected $name;
    
    /**
     * @ORM\Column(name="original_name", length=255)
     */
    protected $originalName;
    
    
    public function __construct($name)
    {
        $this->name = $name;
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
     * Set name
     *
     * @param string $name
     * @return CallAttach
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
     * Set originalName
     *
     * @param string $originalName
     * @return CallAttach
     */
    public function setOriginalName($originalName)
    {
        $this->originalName = $originalName;
    
        return $this;
    }

    /**
     * Get originalName
     *
     * @return string 
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }

    /**
     * Set call
     *
     * @param \Crm\AbonentBundle\Entity\Call\Support $call
     * @return CallAttach
     */
    public function setCall(\Crm\AbonentBundle\Entity\Call\Support $call = null)
    {
        $this->call = $call;
    
        return $this;
    }

    /**
     * Get call
     *
     * @return \Crm\AbonentBundle\Entity\Call\Support 
     */
    public function getCall()
    {
        return $this->call;
    }
    

    /**
     * Get AbsolutePath
     *
     * @return string
     */
    public function getAbsolutePath()
    {
        return null === $this->name ? null : $this->getUploadRootDir().$this->name;
    }

    /**
     * Get WebPath
     *
     * @return string
     */
    public function getWebPath()
    {
        return null === $this->name ? null : $this->getUploadDir().$this->name;
    }

    /**
     * Get UploadRootDir
     *
     * @return string
     */
    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__.'/../../../../../web/'.$this->getUploadDir();
    }

    /**
     * Get UploadDir
     *
     * @return string
     */
    protected function getUploadDir()
    {
        if( !is_dir(__DIR__.'/../../../../../web/uploads/call_attach/') )
        {
            mkdir( __DIR__.'/../../../../../web/uploads/call_attach/',0777 );
        }
        return 'uploads/call_attach/';
    }

    /**
     * upload
     *
     * @return false
     */
    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->name)
        {
            return;
        }
        
        $this->originalName = $this->name->getClientOriginalName();
        
        $n = time().'__'.preg_replace ("/[^_a-zA-ZА-Яа-я0-9\.]/","",$this->name->getClientOriginalName());

        // move takes the target directory and then the target filename to move to
        $this->name->move( $this->getUploadRootDir(), $n );
        
        $this->name = $n;
    }
}