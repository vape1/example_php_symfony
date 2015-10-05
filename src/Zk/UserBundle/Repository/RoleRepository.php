<?php
namespace Zk\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

class RoleRepository extends EntityRepository
{
    /**
     * ID => Name
     * 
     * @return array
     */
    //public function getArrayRoles()
    //{
    //    $q = $this->createQueryBuilder('r')->orderBy('r.id')->getQuery();
    //    $result = array(''=>'');
    //    foreach($q->getResult() as $role)
    //    {
    //        $result[$role->getId()] = $role;
    //    }
    //    return $result;
    //}
}
