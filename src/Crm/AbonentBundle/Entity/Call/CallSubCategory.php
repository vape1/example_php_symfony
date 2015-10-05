<?php
namespace Crm\AbonentBundle\Entity\Call;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
#use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Crm\AbonentBundle\Repository\CallSubCategoryRepository")
 * @ORM\Table(name="call_sub_category")
 * @ORM\HasLifecycleCallbacks()
 */
class CallSubCategory
{
    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Crm\AbonentBundle\Entity\Call\CallCategory", inversedBy="subcategories")
     * @ORM\JoinColumn(name="cat_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $category;

    /**
     * @ORM\Column(length=64)
     */
    protected $name;
        
    /**
     * @ORM\Column(name="auto_quest",length=255, nullable=true)
     */
    protected $autoQuest;

    /**
     * @ORM\Column(name="auto_answer",length=255, nullable=true)
     */
    protected $autoAnswer;

    /**
     * @ORM\Column(length=255, nullable=true)
     */
    protected $descr;
    
    /**
     * @ORM\Column(name="is_active",type="boolean")
     */
    protected $isActive;    


    /**
     * __toString
     *
     * @return string  $name
     */
    public function __toString()
    {
        return $this->name;
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
     * @return CallSubCategory
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
     * Set autoQuest
     *
     * @param string $autoQuest
     * @return CallSubCategory
     */
    public function setAutoQuest($autoQuest)
    {
        $this->autoQuest = $autoQuest;
    
        return $this;
    }

    /**
     * Get autoQuest
     *
     * @return string 
     */
    public function getAutoQuest()
    {
        return $this->autoQuest;
    }

    /**
     * Set autoAnswer
     *
     * @param string $autoAnswer
     * @return CallSubCategory
     */
    public function setAutoAnswer($autoAnswer)
    {
        $this->autoAnswer = $autoAnswer;
    
        return $this;
    }

    /**
     * Get autoAnswer
     *
     * @return string 
     */
    public function getAutoAnswer()
    {
        return $this->autoAnswer;
    }

    /**
     * Set descr
     *
     * @param string $descr
     * @return CallSubCategory
     */
    public function setDescr($descr)
    {
        $this->descr = $descr;
    
        return $this;
    }

    /**
     * Get descr
     *
     * @return string 
     */
    public function getDescr()
    {
        return $this->descr;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return CallSubCategory
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    
        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set category
     *
     * @param \Crm\AbonentBundle\Entity\Call\CallCategory $category
     * @return CallSubCategory
     */
    public function setCategory(\Crm\AbonentBundle\Entity\Call\CallCategory $category = null)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return \Crm\AbonentBundle\Entity\Call\CallCategory 
     */
    public function getCategory()
    {
        return $this->category;
    }
}