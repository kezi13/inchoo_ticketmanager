<?php
class Inchoo_TicketManager_Block_Adminhtml_Ticket extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'inchoo_ticketmanager';
        $this->_controller = 'adminhtml_edit';
        $this->_headerText = Mage::helper('inchoo_ticketmanager')->__('Tickets - all tickets lists;');
        parent::__construct();
        $this->_removeButton('add');
    }
}