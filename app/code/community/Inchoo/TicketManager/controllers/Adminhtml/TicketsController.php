<?php

class Inchoo_TicketManager_Adminhtml_TicketsController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('customer/tickets');

        $this->_title($this->__('Tickets'))->_title($this->__('Tickets'));

        return $this;

    }

    public function indexAction()
    {

        $this->_initAction();
        $this->_addContent($this->getLayout()->createBlock('inchoo_ticketmanager/adminhtml_ticket'));
        $this->renderLayout();

    }


    protected function _validateSecretKey()
    {
        return true;
    }


    public function editAction()
    {

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('ticket_id');
        $model = Mage::getModel('inchoo_ticketmanager/ticket');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('cms')->__('This ticket no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getSubject() : $this->__('New Ticket'));

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (! empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        Mage::register('ticket', $model);

        // 5. Build edit form

        $this->_initAction();

        $this->_addContent($this->getLayout()->createBlock('inchoo_ticketmanager/adminhtml_edit'));

        $this->renderLayout();

    }

    public function saveAction()
    {
        // check if data sent
        if ($data = $this->getRequest()->getPost()) {

            $id = $this->getRequest()->getParam('ticket_id');

            $ticket = Mage::getModel('inchoo_ticketmanager/ticket')->load($id);
            if (!$ticket->getId() && $id) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('cms')->__('This ticket no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }

            if(empty($data['subject'])){
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('cms')->__('Subject field cannot be empty.'));
                $this->_redirect('*/*/');
                return;
            }

            $ticket->setData($data);

            // try to save it
            try {
                // save the data
                $ticket->save();

                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('cms')->__('The ticket has been saved.'));
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('ticket_id' => $ticket->getId()));
                    return;
                }
                // go to grid
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // save data in session
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                // redirect to edit form
                $this->_redirect('*/*/edit', array('ticket_id' => $this->getRequest()->getParam('ticket_id')));
                return;
            }
        }
        $this->_redirect('*/*/');

    }

    public function replyAction()
    {

        if ($data = $this->getRequest()->getPost()) {

            $id = $this->getRequest()->getParam('ticket_id');


            $ticket = Mage::getModel('inchoo_ticketmanager/ticket')->load($id);

            if (!$ticket->getId() && $id) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('cms')->__('This ticket no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }

            if (empty($data['message'])) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('cms')->__('Message field cannot be empty.'));
                $this->_redirect('*/*/');
                return;
            }

            $message = Mage::getModel('inchoo_ticketmanager/message');
            $message->setTicketId($id);
            $message->setMessage($data['message']);
            $message->setIsAdmin(1);
            $created_date = date("Y-m-d H:i:s");
            $message->setCreatedAt($created_date);


            // try to save it
            try {
                // save the data
                $message->save();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('cms')->__('The message has been saved.'));
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('ticket_id' => $message->getId()));
                    return;
                }
                // go to grid
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // save data in session
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                // redirect to edit form
                $this->_redirect('*/*/edit', array('ticket_id' => $this->getRequest()->getParam('ticket_id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        // check if we know what should be deleted
        if ($id = $this->getRequest()->getParam('ticket_id')) {
            $title = "";
            try {
                // init model and delete
                $ticket = Mage::getModel('inchoo_ticketmanager/ticket');
                $ticket->load($id);
                $ticket->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('cms')->__('The ticket has been deleted.'));
                // go to grid
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // go back to edit form
                $this->_redirect('*/*/edit', array('ticket_id' => $id));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('cms')->__('Unable to find a ticket to delete.'));
        // go to grid
        $this->_redirect('*/*/');

    }

}