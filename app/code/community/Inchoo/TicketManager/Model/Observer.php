<?php
class Inchoo_TicketManager_Model_Observer
{
    public function intercept($observer = null)
    {
        $event = $observer->getEvent();

        $admin_inbox = Mage::getModel('adminnotification/inbox');
        $admin_inbox->setSeverity(1);
        $admin_inbox->setTitle($event->getSubject());
        $admin_inbox->setDescription($event->getMessage());
        $admin_inbox->save();

    }
}