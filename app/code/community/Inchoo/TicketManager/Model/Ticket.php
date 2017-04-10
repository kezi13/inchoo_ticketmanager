<?php

class Inchoo_TicketManager_Model_Ticket extends Mage_Core_Model_Abstract

{
    protected $_eventPrefix = 'inchoo_ticketmanager_ticket';
    protected $_eventObject = 'ticket';

    public function _construct()
    {
        $this->_init('inchoo_ticketmanager/ticket');
    }



    public function getMessages()
    {
        $messageCollection = Mage::getModel('inchoo_ticketmanager/message')->getCollection();
        $messageCollection->addFieldToFilter('ticket_id', $this->getId());
        return $messageCollection;
    }


}