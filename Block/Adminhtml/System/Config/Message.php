<?php


namespace Droppery\Core\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * Class Message
 * @package Droppery\Core\Block\Adminhtml\System\Config
 */
class Message extends Field
{
    /**
     * Render text
     *
     * @param AbstractElement $element
     *
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $html = '<td colspan="3" id="droppery-module-message-id">
                    <div id="droppery-module-messages" class="droppery-module-messages" style="display: none">
                        <div class="messages">
                            <div class="message message-error">
                                <div data-ui-id="messages-message-error"></div>
                            </div>
                        </div>
                    </div>
                </td>';

        return $this->_decorateRowHtml($element, $html);
    }

    /**
     * Return element html
     *
     * @param AbstractElement $element
     *
     * @return string
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        return $this->_toHtml();
    }
}
