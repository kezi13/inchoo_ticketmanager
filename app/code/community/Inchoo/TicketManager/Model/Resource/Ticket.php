<?php
class Inchoo_TicketManager_Model_Resource_Ticket extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {

    $this->_init('inchoo_ticketmanager/ticket','ticket_id');

    }
}