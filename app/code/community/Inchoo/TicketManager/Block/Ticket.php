<?php
/**
 * Created by PhpStorm.
 * User: kezi
 * Date: 02.04.17.
 * Time: 13:08
 */

 class Inchoo_TicketManager_Block_Ticket extends Mage_Core_Block_Template
 {


     public function getMessages()
     {

         $id = Mage::registry('ticket')->getTicketId();

         $messages = Mage::getModel('inchoo_ticketmanager/message')->getCollection();
         $messages->addFilter('ticket_id', $id);

         return $messages;

     }

     public function getTickets()
     {
         $tickets = Mage::getModel('inchoo_ticketmanager/ticket')->getCollection();

         $customerData = Mage::getSingleton('customer/session')->getCustomer();
         $tickets->addFilter('customer_id', $customerData->getId());

         return $tickets;
     }

     public function getCustomerName()
     {

        return Mage::getSingleton('customer/session')->getCustomer()->getName();

     }

 }