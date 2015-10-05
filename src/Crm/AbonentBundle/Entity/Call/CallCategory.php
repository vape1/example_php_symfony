<?php
namespace Crm\AbonentBundle\Entity\Call;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
#use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Crm\AbonentBundle\Repository\CallCategoryRepository")
 * @ORM\Table(name="call_category")
 * @ORM\HasLifecycleCallbacks()
 */
class CallCategory
{
    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(length=64)
     */
    protected $name;
        
    /**
     * @ORM\Column(length=255, nullable=true)
     */
    protected $descr;
    
    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    protected $isActive;    

    /**
     * @ORM\OneToMany(targetEntity="Crm\AbonentBundle\Entity\Call\CallSubCategory", mappedBy="category", cascade={"persist", "remove", "merge"})
     */
    protected $subcategories;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->subcategories = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return CallCategory
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
     * Set descr
     *
     * @param string $descr
     * @return CallCategory
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
     * @return CallCategory
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
     * Add subcategories
     *
     * @param \Crm\AbonentBundle\Entity\Call\CallSubCategory $subcategories
     * @return CallCategory
     */
    public function addSubcategorie(\Crm\AbonentBundle\Entity\Call\CallSubCategory $subcategories)
    {
        $this->subcategories[] = $subcategories;
    
        return $this;
    }

    /**
     * Remove subcategories
     *
     * @param \Crm\AbonentBundle\Entity\Call\CallSubCategory $subcategories
     */
    public function removeSubcategorie(\Crm\AbonentBundle\Entity\Call\CallSubCategory $subcategories)
    {
        $this->subcategories->removeElement($subcategories);
    }

    /**
     * Get subcategories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubcategories()
    {
        return $this->subcategories;
    }
}