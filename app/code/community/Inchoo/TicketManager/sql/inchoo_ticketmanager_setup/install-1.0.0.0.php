<?php

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()->newTable($installer->getTable('inchoo_ticketmanager/ticket'))
    ->addColumn('ticket_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
        ), 'Ticket id')
    ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'unsigned' => true,
            'nullable' => false,
        ), 'Customer id')
    ->addColumn('subject', Varien_Db_Ddl_Table::TYPE_VARCHAR, 100,
        array(
            'nullable' => false,
        ), 'subject')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null,
        array(
            'nullable' => false,
        ), 'Timestamp')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_BOOLEAN, null,
        array(
            'nullable' => false,
        ), 'status')
    ->addForeignKey(
        $installer->getFkName(
            'inchoo_ticketmanager/ticket',
            'customer_id',
            'customer/entity',
            'entity_id'
        ),
        'customer_id',
        $installer->getTable('customer/entity'),
        'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Inchoo_TicketManager Ticket Entity');

$installer->getConnection()->createTable($table);


$table = $installer->getConnection()->newTable($installer->getTable('inchoo_ticketmanager/message'))
    ->addColumn('message_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
        ), 'Message id')
    ->addColumn('ticket_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'unsigned' => true,
            'nullable' => false,
        ), 'Ticket id')
    ->addColumn('is_admin', Varien_Db_Ddl_Table::TYPE_BOOLEAN, null,
        array(
            'nullable' => false,
        ), 'Is admin')
    ->addColumn('message', Varien_Db_Ddl_Table::TYPE_TEXT, null,
        array(
            'nullable' => false,
        ), 'Message')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null,
        array(
            'nullable' => false,
        ), 'Created at')
    ->addForeignKey(
        $installer->getFkName(
            'inchoo_ticketmanager/message',
            'ticket_id',
            'inchoo_ticketmanager_ticket',
            'ticket_id'
        ),
        'ticket_id',
        $installer->getTable('inchoo_ticketmanager_ticket'),
        'ticket_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->setComment('Inchoo_TicketManager Message Entity');

$installer->getConnection()->createTable($table);

$installer->endSetup();