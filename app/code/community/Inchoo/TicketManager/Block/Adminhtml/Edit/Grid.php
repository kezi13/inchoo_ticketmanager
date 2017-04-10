<?php
class Inchoo_TicketManager_Block_Adminhtml_Edit_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('inchoo_ticketmanager');
        $this->setDefaultSort('ticket_id');
    }
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('inchoo_ticketmanager/ticket')
            ->getCollection();
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }
    protected function _prepareColumns()
    {
        $this->addColumn('ticket_id', array(
            'header' => Mage::helper('inchoo_ticketmanager')->__('ID'),
            'sortable' => true,
            'index' => 'ticket_id',
            'width'=>'10px',

        ));
        $this->addColumn('subject', array(
            'header'    => Mage::helper('inchoo_ticketmanager')->__('Subject'),
            'index'     => 'subject',
            'type'      => 'text',
            'width' => '170px',
        ));
        $this->addColumn('status', array(
            'header'    => Mage::helper('inchoo_ticketmanager')->__('Status'),
            'index'     => 'status',
            'type'      => 'options',
            'options'   => array(
                0 => Mage::helper('cms')->__('Closed'),
                1 => Mage::helper('cms')->__('Active'),
        )));
        $this->addColumn('created_at', array(
            'header'    => Mage::helper('inchoo_ticketmanager')->__('Created At'),
            'index'     => 'created_at',
            'type'      => 'TIMESTAMP',
            'width' => '170px',
        ));

        return parent::_prepareColumns();
    }



    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('ticket_id' => $row->getId()));

    }


}