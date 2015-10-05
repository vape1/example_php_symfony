<?php

namespace Crm\AbonentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Zk\InterfaceBundle\AdminInterface\AdminInterfaceController;

use Symfony\Component\HttpFoundation\Response;
use Crm\AddressesBundle\Entity\Flat;
use Crm\AbonentBundle\Entity\AbonentPh;
use Crm\AbonentBundle\Entity\ContactInfoPh;
use Crm\AbonentBundle\Entity\BaseAbonent;
use Crm\AbonentBundle\Entity\Appl;
use Crm\AbonentBundle\Entity\AbonentService;
use Crm\AbonentBundle\Form\AbonentPhType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * AbonentPh controller.
 *
 */
class AbonentPhController extends AdminInterfaceController
{
    /**
     * @param string $class
     */
    public function __construct()
    {
        parent::__construct('Crm\AbonentBundle\Entity\AbonentPh','aph');
    }
    
    /**
     * mainPage
     *
     */
    public function mainPageAction()
    {
        if ( false === $this->isZkGranded(array('ROLE_ABONENT_PH_VIEW')) )
        {
            throw new AccessDeniedException();
        }
        
        $entity = new AbonentPh();
        $form   = $this->createCreateForm($entity);
        
        $streets = $em->getRepository('CrmAddressesBundle:Street')->findAll();
        
        return $this->render('CrmAbonentBundle:AbonentPh:main.html.twig', array(
           'streets' => $streets,
           'form'   => $form->createView(),
        ));
    }

    /**
     * Lists all AbonentPh entities.
     *
     */
    public function indexAction()
    {
        if ( false === $this->isZkGranded(array('ROLE_ABONENT_PH_VIEW')) )
        {
            throw new AccessDeniedException();
        }
        
        if( $this->isReset() )
        {
            return $this->redirect( $this->generateUrl( $this->get('request')->get('_route') ) );
        }
        
         $this->buildListFields();
        
        $items = $this->getListFields();
        
        $this->getEm()->buildQuery();
        
        $this->getQuery()
            ->select('aph,ba,f,p,h,s,c,ci')
            ->leftJoin('aph.abonent','ba')
            ->leftJoin('aph.contactInfo','ci')
            ->leftJoin('aph.flat','f')
            ->leftJoin('f.parad','p')
            ->leftJoin('p.house','h')
            ->leftJoin('h.street','s')
            ->leftJoin('s.city','c')
        ;
        
        $this->buildFilterFields();
        $this->checkFilters();
        
        $pagination = $this->getPaginator(30);
        
        $filter_form = $this->getViewFiltersForm();
        
        return $this->render('CrmAbonentBundle:AbonentPh:list.html.twig', array(
            'results'     => $pagination,
            'items'       => $items,
            'filter_form' => $filter_form,
        ));
    }
    
    /**
     * buildListFields
     * name,label,alias,sort,func,filter,options,method
     */
    public function buildListFields()
    {
        $this
        ->addInList(array(
            'address',
            $this->trans('a_address','abonent'),
            'aph',
            true,
            null,
            null,
            array('style' => 'text-align:center')
        ));
        
        $this
        ->addInList(array(
            'name',
            $this->trans('aph_abon_name','abonent'),
            'aph',
            true,
            null,
            null,
            array('style' => 'text-align:center')
        ));
        
        $this
        ->addInList(array(
            'balance',
            $this->trans('a_balance','abonent'),
            'ba',
            true,
            null,
            null,
            array('style' => 'text-align:center'),
            'getBalance'
        ));
        
        $this
        ->addInList(array(
            'numDogovor',
            $this->trans('a_numDogovor','abonent'),
            'ba',
            true,
            null,
            null,
            array('link_id' => 'abonentph_edit','style' => 'text-align:center'),
            'getNumDogovor'
        ));
        
        
    }
    
    /**
     * buildListFields
     * name,type,label,count,sort,condition_operator,options
     */
    public function buildFilterFields()
    {
    
        $this->addInFilter(array(
            'aph_bonuceBalance',
            'text_filter',
            $this->trans('c_bonuceBalance','abonent'),
            5,
            'light_text'
        ));
    }

    /**
    * Creates a form to create a AbonentPh entity.
    *
    * @param AbonentPh $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(AbonentPh $entity, $flat_id)
    {
        $form = $this->createForm(new AbonentPhType(), $entity, array(
            'action' => $this->generateUrl('abonentph_new',array('flat_id' => $flat_id)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new AbonentPh entity.
     *
     */
    public function newAction(Request $request, $flat_id)
    {
        if ( false === $this->isZkGranded(array('ROLE_ABONENT_ABONENT_PH_ADD')) )
        {
            throw new AccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();
        
        $user = $this->getTotalUser();
        
        $entity = new AbonentPh();
        
        $entity_contact = new ContactInfoPh($entity);
        $entity_base = new BaseAbonent($entity);
        $entity_appl = new Appl($entity_base, $user);
        $entity_service = new AbonentService($entity);
        
        $entity->setAbonent($entity_base);
        $entity->setContactInfo($entity_contact);
        $entity->setAppl($entity_appl);
        $entity->setService($entity_service);
        
        $flat = $em->getRepository('CrmAddressesBundle:Flat')->find($flat_id);
        $entity->setFlat($flat);
        $flat->addAbonent($entity);
        
        $form = $this->createCreateForm($entity, $flat_id);
        
        $form->handleRequest($request);
         
        if ($form->isValid()) {
            
            //привязка имени
            $request_arr = $request->request->get('crm_abonentbundle_abonentph');
            
            $name = $request_arr['surname'].' '.$request_arr['firstName'].' '.$request_arr['fatherName'];
            
            $entity_base->setName($name);
            
            $em->persist($entity);
            $em->flush();
         
            return $this->redirect($this->generateUrl('abonentph_edit', array('id' => $entity->getId())));
        }
        
        return $this->render('CrmAbonentBundle:AbonentPh:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'flat_id' => $flat_id,
        ));
    }

    /**
     * Finds and displays a AbonentPh entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmAbonentBundle:AbonentPh')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AbonentPh entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmAbonentBundle:AbonentPh:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing AbonentPh entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmAbonentBundle:AbonentPh')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AbonentPh entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmAbonentBundle:AbonentPh:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a AbonentPh entity.
    *
    * @param AbonentPh $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(AbonentPh $entity)
    {
        $form = $this->createForm(new AbonentPhType(), $entity, array(
            'action' => $this->generateUrl('abonentph_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing AbonentPh entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmAbonentBundle:AbonentPh')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AbonentPh entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('abonentph_edit', array('id' => $id)));
        }

        return $this->render('CrmAbonentBundle:AbonentPh:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a AbonentPh entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CrmAbonentBundle:AbonentPh')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AbonentPh entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('abonentph'));
    }

    /**
     * Creates a form to delete a AbonentPh entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('abonentph_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    /**
     * Return an array of house or parad or flat
     *
     * @param mixed $val The entity id of street, house or parad 
     *
     * @return array()
     */
    public function getHouseAction( $val, $type )
    {
        $arr = array('');
        $em = $this->getDoctrine()->getManager();
        
        if($type == 'house'){
            $entities = $em->getRepository('Crm\AddressesBundle\Entity\House')->findByStreet($val);
        }
        elseif($type == 'parad'){
            $entities = $em->getRepository('Crm\AddressesBundle\Entity\Parad')->findByHouse($val);
        }
        elseif($type == 'flat'){
            $entities = $em->getRepository('Crm\AddressesBundle\Entity\Flat')->findByParad($val);
        }
        
        foreach($entities as $entity)
        {
            $arr[$entity->getId()] = $entity->getName();
        }
        
        $response = json_encode( $arr );
     
        return new Response( $response, 200, array('Content-Type'=>'application/json'));
    }
    
    public function getFlatInfoAction($id)
    {
        $arr = array();
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('Crm\AddressesBundle\Entity\Flat')->find($id);
        
        if($entity->getAbonentsInfo())
        {
            $arr = $entity->getAbonentsInfo();
        }
        
        $response = json_encode( $arr );
        
        return new Response( $response, 200, array('Content-Type'=>'application/json'));
    }
    
    public function applUpdateAction($id,$val,$field)
    {
        $arr = array('success'=>1);
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('Crm\AbonentBundle\Entity\Appl')->find($id);
        
        if (!$entity)
        {
            $arr['success'] = 0;
        }
        else
        {
            if($field == 'setNote' and $entity->getNote() and  $entity->getNote() != $val)
            {
                
                $old_val = 'Archive: '.$entity->getNote();
                $new_val = "Edited : (".date('Y-m-d H:i').") "
                    . $this->getTotalUser()->getName()."\n".$val."\n";
                $log =  $new_val."\n". $old_val."_______".$entity->getLog();
                $entity->setLog($log);
            }
            
            $entity->$field($val);
            $em->flush();
        }
        
        $response = json_encode( $arr );
        
        return new Response( $response, 200, array('Content-Type'=>'application/json'));
    }
}
