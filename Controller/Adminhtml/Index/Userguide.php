<?php


namespace Droppery\Core\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class Userguide
 * @package Droppery\Core\Controller\Adminhtml\Index
 */
class Userguide extends Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Droppery_Core::userguide';

    /**
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        $this->_response->setRedirect(
            'https://docs.droppery.com/?utm_source=configuration&utm_medium=link&utm_content=user-guide'
        );
    }
}
