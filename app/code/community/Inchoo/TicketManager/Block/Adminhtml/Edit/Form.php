<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright  Copyright (c) 2006-2017 X.commerce, Inc. and affiliates (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Adminhtml cms block edit form
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Inchoo_TicketManager_Block_Adminhtml_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    /**
     * Init form
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('ticket_form');
        $this->setTitle(Mage::helper('cms')->__('Ticket Information'));

    }

    /**
     * Load Wysiwyg on demand and Prepare layout
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
    }

    protected function _prepareForm()
    {
        $model = Mage::registry('ticket');

        $form = new Varien_Data_Form(
            array('id' => 'edit_form', 'action' => 'http://ticket.loc/index.php/admin/tickets/save', 'method' => 'post')
        );

        $form->setHtmlIdPrefix('ticket_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('cms')->__('General Information'), 'class' => 'fieldset-wide'));

        if ($model->getTicketId()) {
            $fieldset->addField('ticket_id', 'hidden', array(
                'name' => 'ticket_id',
            ));
        }

        $fieldset->addField('subject', 'text', array(
            'name'      => 'subject',
            'label'     => Mage::helper('cms')->__('Ticket Subject'),
            'title'     => Mage::helper('cms')->__('Ticket Subject'),
            'required'  => true,
        ));

        $fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('cms')->__('Status'),
            'title'     => Mage::helper('cms')->__('Status'),
            'name'      => 'status',
            'onchange'  => 'changeStatus()',
            'required'  => true,
            'options'   => array(
                '1' => Mage::helper('cms')->__('Active'),
                '0' => Mage::helper('cms')->__('Closed'),
            ),
        ));


        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        $paragraph_block = $this->getLayout()->createBlock('core/template'); // new Mage_Core_Block_Template();
        $paragraph_block->setTemplate('ticketmanager/message.phtml');

        $this->setChild('form_after',$paragraph_block);

        return parent::_prepareForm();
    }


}
