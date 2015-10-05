<?php
namespace Crm\AbonentBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
 
class ChangeUpdateListener
{
    protected $container;
  
    public function __construct($container)
    {
        $this->container = $container;
    }
  
    /**
     * prePersist
     * 
     * Перед добавлением ЛЮБОГО Entity
     * 
     * @param LifecycleEventArgs $args
    */
    public function prePersist(LifecycleEventArgs $args)
    {
        if( $args->getEntity() instanceof \Crm\AbonentBundle\Entity\AbonentPh ) 
        {
            $this->prePersistAbonentPh($args);
        }
        //if( $args->getEntity() instanceof \Crm\AbonentBundle\Entity\Appl ) 
        //{
        //    $this->prePersistAppl($args);
        //}
    }

    /**
     * preUpdate
     * 
     * Перед обновлением ЛЮБОГО Entity
     * 
     * @param LifecycleEventArgs $args
    */
    public function preUpdate(LifecycleEventArgs $args)
    {
        //if( $args->getEntity() instanceof \Rodina\CrmBundle\Entity\Abonent\Payment ) 
        //{
        //    $this->preUpdatePayment($args);
        //}
    }

    /**
     * postUpdate
     * 
     * После обновления ЛЮБОГО Entity
     * 
     * @param LifecycleEventArgs $args
    */
    public function postUpdate(LifecycleEventArgs $args)
    {
    }

    /**
     * postPersist
     * 
     * После добавления ЛЮБОГО Entity
     * 
     * @param LifecycleEventArgs $args
    */
    public function postPersist(LifecycleEventArgs $args)
    {
        //if( $args->getEntity() instanceof \Rodina\CrmBundle\Entity\Abonent\AbonentBonuceDay ) 
        //{
        //    $this->postPersistAbonentBonuceDay($args);
        //}
    }

    /**
     * prePersistAbonent
     * 
     * @param LifecycleEventArgs $args
    */
    protected function prePersistAbonentPh(LifecycleEventArgs $args)
    {
        $object = $args->getEntity();
        $em = $args->getEntityManager();
        
        $repo = $em->getRepository('CrmAbonentBundle:BaseAbonent');
        
        for($j = 0; $j < 10000; $j++)
        {
            $dogovor = '0';
            $dogovor .= (string)rand(100001,999999);
            $is_isset = $repo->findByNumDogovor( $dogovor );
            if( !$is_isset )
            {
                $object->getAbonent()->setNumDogovor( $dogovor );
                
                return true;
            }
        }
        return false;
    }

    /**
     * prePersistAbonement
     * 
     * @param LifecycleEventArgs $args
    */
    protected function prePersistAbonement(LifecycleEventArgs $args)
    {
        $object = $args->getEntity();
        $em = $args->getEntityManager();
        
        $repo = $em->getRepository('Rodina\CrmBundle\Entity\Abonent\Abonement');
        
        for($j = 0; $j < 10000; $j++)
        {
            $login = '1';
            $login .= (string)rand(100001,999000);
            $is_isset = $repo->findByLogin( $login );
            if( !$is_isset )
            {
                $object->setLogin( $login );
                return true;
            }
        }
        return false;
    }

    /**
     * postPersistAbonentBonuceDay
     * 
     * @param LifecycleEventArgs $args
    */
    protected function postPersistAbonentBonuceDay(LifecycleEventArgs $args)
    {
        $object = $args->getEntity();
        $em = $args->getEntityManager();
        
        $abonent = $object->getAbonent();
        $bonuces = $object->getQuantity();
        
        $active_abonements = $abonent->getAbonements()->filter(function($abonement) {
            return $abonement->getStatus() === 0; 
        });
        
        $bonuce_in_abonement = ceil( $bonuces / $active_abonements->count() );
        
        if( $bonuce_in_abonement )
        {
            foreach( $active_abonements as $abonement )
            {
                if( $bonuces < 1 ) break;
                
                $q_days = $bonuces > $bonuce_in_abonement ? $bonuce_in_abonement : $bonuces;
                
                $AbonementBonuceDay = new \Rodina\CrmBundle\Entity\Abonent\AbonementBonuceDay(
                    $object, $abonement, $q_days
                );
                $em->persist( $AbonementBonuceDay );
                
                $abonement->addBonuceFinishDate( $q_days );
                
                $bonuces -= $q_days;
                $object->setIsAdded(true);
            }
        }
        
        $em->flush();
    }
    
    /**
     * preUpdatePayment
     * 
     * @param LifecycleEventArgs $args
    */
    protected function preUpdatePayment(LifecycleEventArgs $args)
    {
        $object = $args->getEntity();
        $em = $args->getEntityManager();
        
        $array_changes = $args->getEntityChangeSet();
        //echo"<pre>";print_r($array_changes['paymentSystem'][0]->getName());echo"</pre>";exit;
        
        if( isset($array_changes['amount']) or isset($array_changes['paymentSystem']) or isset($array_changes['flag']) )
        {
            $uow = $em->getUnitOfWork();
            
            $PaymentChanged = new \Rodina\CrmBundle\Entity\Abonent\PaymentChanged(
                $object,
                isset($array_changes['amount']) ? $array_changes['amount'][0] : $object->getAmount(),
                isset($array_changes['comment']) ? $array_changes['comment'][0] : $object->getComment(),
                isset($array_changes['paySystem']) ? $array_changes['paySystem'][0] : $object->getPaySystem(),
                isset($array_changes['payType']) ? $array_changes['payType'][0] : $object->getPayType(),
                isset($array_changes['payServiceComment']) ? $array_changes['payServiceComment'][0] : $object->getPayServiceComment(),
                isset($array_changes['receipt']) ? $array_changes['receipt'][0] : $object->getReceipt(),
                isset($array_changes['payDate']) ? $array_changes['payDate'][0] : $object->getPayDate(),
                isset($array_changes['localDate']) ? $array_changes['localDate'][0] : $object->getLocalDate(),
                isset($array_changes['flag']) ? $array_changes['flag'][0] : $object->getFlag(),
                isset($array_changes['paymentSystem']) ? $array_changes['paymentSystem'][0] : $object->getPaymentSystem(),
                isset($array_changes['manager']) ? $array_changes['manager'][0] : $object->getManager()
            );
            $em->persist( $PaymentChanged );
            
            $object->addChange( $PaymentChanged );
            $uow->recomputeSingleEntityChangeSet(
                $em->getClassMetadata("Rodina\CrmBundle\Entity\Abonent\Payment"),
                $object
            );
        }
    }
}
