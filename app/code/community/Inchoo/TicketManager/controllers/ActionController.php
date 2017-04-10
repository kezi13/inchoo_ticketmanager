<?php

class Inchoo_TicketManager_ActionController extends Mage_Core_Controller_Front_Action
{
    public function preDispatch(){
        parent::preDispatch();

        if(!Mage::getSingleton('customer/session')->isLoggedIn()) {
            $this->norouteAction();
            return;
        }

    }

    public function indexAction(){
        $this->loadLayout();
/*        var_dump($this->loadLayout());*/

        $this->renderLayout();
        /*var_dump($this->renderLayout());*/
    }

    public function viewAction(){
        $ticket = Mage::getModel('inchoo_ticketmanager/ticket');

        if(!$this->isValidTicket($ticket))
        {

            Mage::getSingleton('core/session')->addError('Ticket not found!');
            $this->norouteAction();
            return;

        }

        $this->loadLayout();


        $navigationBlock = $this->getLayout()->getBlock('customer_account_navigation');
        if ($navigationBlock) {
            $navigationBlock->setActive('inchoo_ticketmanager/action');
        }

        $this->renderLayout();
    }


    public function newAction(){
        $this->loadLayout();

        $navigationBlock = $this->getLayout()->getBlock('customer_account_navigation');

        if ($navigationBlock) {
            $navigationBlock->setActive('inchoo_ticketmanager/action');
        }


        $this->renderLayout();
    }

    public function newPostAction(){
        if(!$this->getRequest()->isPost()) {
            $this->norouteAction();

            return;
        }

        $ticketForm = $this->getRequest()->getPost();

        if(empty($ticketForm['subject']) || empty($ticketForm['message'])) {
            $this->norouteAction();
            return;
        }

        $ticket = Mage::getModel('inchoo_ticketmanager/ticket');
        $customerData = Mage::getSingleton('customer/session')->getCustomer();
        $created_date = date("Y-m-d H:i:s");

        $ticket->setCustomerId($customerData->getId());
        $ticket->setStatus(1);
        $ticket->setSubject(trim($ticketForm['subject']));
        $ticket->setCreatedAt($created_date);
        $ticket->save();


        $message = Mage::getModel('inchoo_ticketmanager/message');

        $message->setMessage(trim($ticketForm['message']));
        $message->setTicketId($ticket->getTicketId());
        $message->setIsAdmin(0);
        $message->setCreatedAt($created_date);

        $message->save();

        $ticket->setMessage($message->getMessage());

        Mage::dispatchEvent('new_ticket',$ticket);

        Mage::getSingleton('core/session')->addSuccess('Success Ticket');

        $this->_redirectUrl('/tickets/action');

    }

    public function closePostAction(){

        if(!$this->getRequest()->isPost()){
            $this->norouteAction();
            return;
        }


        $ticket = Mage::getModel('inchoo_ticketmanager/ticket');

        if(!$this->isValidTicket($ticket)){

            $this->norouteAction();
            return;

        }

        $closeForm = $this->getRequest()->getPost();
;
        $ticket->setTicketId($closeForm['ticket_id']);
        $ticket->setStatus(0);
        $ticket->save();

        Mage::getSingleton('core/session')->addSuccess('Ticket '.$ticket->getId().' is closed');


        $this->_redirectUrl('/tickets/action');
    }

    public function replyPostAction(){

        if(!$this->getRequest()->isPost()) {
            $this->norouteAction();
            return;
        }

        $ticket = Mage::getModel('inchoo_ticketmanager/ticket');

        if(!$this->isValidTicket($ticket)){

            Mage::getSingleton('core/session')->addError('Ticket not found!');
            $this->norouteAction();
            return;
        }

        $replyForm = $this->getRequest()->getPost();

        if(empty($replyForm['message'])) {
            $this->norouteAction();
            return;
        }

        $message = Mage::getModel('inchoo_ticketmanager/message');
        $message->setTicketId($replyForm['ticket_id']);
        $message->setMessage(trim($replyForm['message']));
        $message->setIsAdmin(0);
        $message->setCreatedAt(date("Y-m-d H:i:s"));


        $message->save();

        $this->_redirectUrl('/tickets/action/view/ticket_id/'.$replyForm['ticket_id']);

    }

    protected function isValidTicket($ticket){
        $is_valid = true;

        $id = $this->getRequest()->getParams('ticket_id');

        $ticket->load($id['ticket_id']);

        if(!$ticket->getId()) {

            $is_valid=false;

        }


        $customerData = Mage::getSingleton('customer/session')->getCustomer();

        if($customerData->getId() != $ticket->getCustomerId()){

            $is_valid=false;

        }

        if($is_valid) Mage::register('ticket',$ticket);

        return $is_valid;
    }


}