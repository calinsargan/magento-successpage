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

        $lastQuoteId = $session->getLastQuoteId();
        $lastOrderId = $session->getLastOrderId();
        $lastRecurringProfiles = $session->getLastRecurringProfileIds();
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