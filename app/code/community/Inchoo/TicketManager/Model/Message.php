<?php

class Inchoo_TicketManager_Model_Message extends Mage_Core_Model_Abstract

{
    protected $_eventPrefix = 'inchoo_ticketmanager_message';
    protected $_eventObject = 'message';

    public function _construct()
    {
        $this->_init('inchoo_ticketmanager/message');
    }
}