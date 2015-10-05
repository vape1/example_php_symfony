<?php

namespace Crm\AbonentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Crm\AbonentBundle\Entity\ContactInfoPh;
use Crm\AbonentBundle\Form\ContactInfoPhType;

/**
 * ContactInfoPh controller.
 *
 */
class ContactInfoPhController extends Controller
{

    /**
     * Lists all ContactInfoPh entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CrmAbonentBundle:ContactInfoPh')->findAll();

        return $this->render('CrmAbonentBundle:ContactInfoPh:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new ContactInfoPh entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ContactInfoPh();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('contactinfoph_show', array('id' => $entity->getId())));
        }

        return $this->render('CrmAbonentBundle:ContactInfoPh:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a ContactInfoPh entity.
    *
    * @param ContactInfoPh $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(ContactInfoPh $entity)
    {
        $form = $this->createForm(new ContactInfoPhType(), $entity, array(
            'action' => $this->generateUrl('contactinfoph_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ContactInfoPh entity.
     *
     */
    public function newAction()
    {
        $entity = new ContactInfoPh();
        $form   = $this->createCreateForm($entity);

        return $this->render('CrmAbonentBundle:ContactInfoPh:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ContactInfoPh entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmAbonentBundle:ContactInfoPh')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContactInfoPh entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmAbonentBundle:ContactInfoPh:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing ContactInfoPh entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmAbonentBundle:ContactInfoPh')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContactInfoPh entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmAbonentBundle:ContactInfoPh:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a ContactInfoPh entity.
    *
    * @param ContactInfoPh $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ContactInfoPh $entity)
    {
        $form = $this->createForm(new ContactInfoPhType(), $entity, array(
            'action' => $this->generateUrl('contactinfoph_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ContactInfoPh entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmAbonentBundle:ContactInfoPh')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContactInfoPh entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('contactinfoph_edit', array('id' => $id)));
        }

        return $this->render('CrmAbonentBundle:ContactInfoPh:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a ContactInfoPh entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CrmAbonentBundle:ContactInfoPh')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ContactInfoPh entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('contactinfoph'));
    }

    /**
     * Creates a form to delete a ContactInfoPh entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('contactinfoph_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
