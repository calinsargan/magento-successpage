<?php
require_once 'Mage/Checkout/controllers/OnepageController.php';
 
class Copimaj_SuccessPage_OnepageController extends Mage_Checkout_OnepageController {
 
    /**
     * Index action 
     */
    public function indexAction() {
       
       parent::indexAction();
    }

    /**
     * Order success action
     */
    public function successAction()
    {
        $session = $this->getOnepage()->getCheckout();
        // if (!$session->getLastSuccessQuoteId()) {
        //     $this->_redirect('checkout/cart');
        //     return;
        // }
        $lastOrder = Mage::getModel('sales/order')->getCollection()
           ->setOrder('entity_id','DESC')
           ->setPageSize(1)
           ->getFirstItem();


        $lastQuoteId = $lastOrder->getQuoteId();
        $lastOrderId = $lastOrder->getId();
        // $lastRecurringProfiles = $session->getLastRecurringProfileIds();
        // if (!$lastQuoteId || (!$lastOrderId && empty($lastRecurringProfiles))) {
        //     $this->_redirect('checkout/cart');
        //     return;
        // }
        
        
        // $session->clear();
        $this->loadLayout();
        $this->_initLayoutMessages('checkout/session');
        Mage::dispatchEvent('checkout_onepage_controller_success_action', array('order_ids' => array($lastOrderId)));
        $this->renderLayout();
    }
}