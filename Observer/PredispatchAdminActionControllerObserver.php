<?php


namespace Droppery\Core\Observer;

use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Droppery\Core\Helper\AbstractData;
use Droppery\Core\Model\Feed;

/**
 * Class PredispatchAdminActionControllerObserver
 * @package Droppery\Core\Observer
 */
class PredispatchAdminActionControllerObserver implements ObserverInterface
{
    /**
     * @type Session
     */
    protected $_backendAuthSession;

    /**
     * @var AbstractData
     */
    protected $helper;

    /**
     * PredispatchAdminActionControllerObserver constructor.
     *
     * @param Session $backendAuthSession
     * @param AbstractData $helper
     */
    public function __construct(
        Session $backendAuthSession,
        AbstractData $helper
    ) {
        $this->_backendAuthSession = $backendAuthSession;
        $this->helper = $helper;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        if ($this->_backendAuthSession->isLoggedIn()
            && $this->helper->isModuleOutputEnabled('Magento_AdminNotification')) {
            /* @var $feedModel Feed */
            $feedModel = $this->helper->createObject(Feed::class);
            $feedModel->checkUpdate();
        }
    }
}
