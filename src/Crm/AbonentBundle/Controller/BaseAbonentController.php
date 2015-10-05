<?php

namespace Crm\AbonentBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Crm\AbonentBundle\Entity\BaseAbonent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
/**
 * BaseAbonent controller.
 *
 */
class BaseAbonentController extends Controller
{

    /**
     * Lists all BaseAbonent entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $streets = $em->getRepository('CrmAddressesBundle:Street')->findAll();
        
        return $this->render('CrmAbonentBundle:AbonentPh:main.html.twig', array(
           'streets' => $streets,
        ));
    }
    
    /**
     * Redirect to correct Abonent
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $base_abonent = $em->getRepository('CrmAbonentBundle:BaseAbonent')->find($id);
        
        if(!$base_abonent)
        {
            throw new NotFoundHttpException('Абонента не знайдено!');
        }
        
        $entity = $base_abonent->getAbonent();
        $class = $entity->getClassName();
        
        return $this->redirect($this->generateUrl($class.'_edit', array('id' => $entity->getId())));
    }
    
    /**
     * Check Parad information
     *
     */
    public function checkParadAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $entity = $em->getRepository('Crm\AddressesBundle\Entity\Parad')->find($id);
        
        if (!$entity) {
            $arr = array();
        }
        else {
            $arr = array('ableConn'=>$entity->getAbleConn(),'accessParad'=>$entity->getAccessParad(),
                            'comments'=>$entity->getCommentAccessParad());
        }
        
        $response = json_encode( $arr );
     
        return new Response( $response, 200, array('Content-Type'=>'application/json'));
    }

    /**
     * Finds and displays a BaseAbonent entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmAbonentBundle:BaseAbonent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BaseAbonent entity.');
        }

        return $this->render('CrmAbonentBundle:BaseAbonent:show.html.twig', array(
            'entity'      => $entity,
        ));
    }
    
    /**
     * Finds and displays a BaseAbonent entity.
     *
     */
    public function findAction(Request $request)
    {
        $row = $request->query->get('row');
        $term = $request->query->get('term');
        $arr = array();
        
        $em = $this->getDoctrine()->getManager();
     
        $entities = $em->getRepository('CrmAbonentBundle:BaseAbonent')->createQueryBuilder('ba')
            ->where('ba.numDogovor LIKE :term')
            ->setParameter('term',  $term.'%')
            ->getQuery()
            ->getResult();
     
        foreach($entities as $entity)
        {
            $arr[$entity->getId()] = $entity->getNumDogovor();
        }
        
        $response = json_encode( $arr );
     
        return new Response( $response, 200, array('Content-Type'=>'application/json'));
    }
}
