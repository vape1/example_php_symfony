<?php

namespace Crm\AbonentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StatisticInfo
 *
 * @ORM\Table(name="abonent_statistic_info")
 * @ORM\Entity
 */
class StatisticInfo
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
     * @ORM\OneToOne(targetEntity="Crm\AbonentBundle\Entity\BaseAbonent", inversedBy="statisticInfo")
     * @ORM\JoinColumn(name="abonent_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $abonent;
    
    /**
     * @ORM\Column(name="act_days",type="integer")
     */
    protected $act_days;
    
    /**
     * @ORM\Column(name="block_days",type="integer")
     */
    protected $block_days;
    
    /**
     * @ORM\Column(name="count_block",type="integer")
     */
    protected $count_block;
    
    /**
     * @ORM\Column(name="count_block_row",type="integer")
     */
    protected $count_block_row;
    
    /**
     * @ORM\Column(name="loyal",type="boolean")
     */
    protected $loyal;

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
     * Set act_days
     *
     * @param integer $actDays
     * @return StatisticInfo
     */
    public function setActDays($actDays)
    {
        $this->act_days = $actDays;
    
        return $this;
    }

    /**
     * Get act_days
     *
     * @return integer 
     */
    public function getActDays()
    {
        return $this->act_days;
    }

    /**
     * Set block_days
     *
     * @param integer $blockDays
     * @return StatisticInfo
     */
    public function setBlockDays($blockDays)
    {
        $this->block_days = $blockDays;
    
        return $this;
    }

    /**
     * Get block_days
     *
     * @return integer 
     */
    public function getBlockDays()
    {
        return $this->block_days;
    }

    /**
     * Set count_block
     *
     * @param integer $countBlock
     * @return StatisticInfo
     */
    public function setCountBlock($countBlock)
    {
        $this->count_block = $countBlock;
    
        return $this;
    }

    /**
     * Get count_block
     *
     * @return integer 
     */
    public function getCountBlock()
    {
        return $this->count_block;
    }

    /**
     * Set count_block_row
     *
     * @param integer $countBlockRow
     * @return StatisticInfo
     */
    public function setCountBlockRow($countBlockRow)
    {
        $this->count_block_row = $countBlockRow;
    
        return $this;
    }

    /**
     * Get count_block_row
     *
     * @return integer 
     */
    public function getCountBlockRow()
    {
        return $this->count_block_row;
    }

    /**
     * Set loyal
     *
     * @param boolean $loyal
     * @return StatisticInfo
     */
    public function setLoyal($loyal)
    {
        $this->loyal = $loyal;
    
        return $this;
    }

    /**
     * Get loyal
     *
     * @return boolean 
     */
    public function getLoyal()
    {
        return $this->loyal;
    }

    /**
     * Set abonent
     *
     * @param \Crm\AbonentBundle\Entity\Abonent $abonent
     * @return StatisticInfo
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
}