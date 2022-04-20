<?php


namespace Droppery\Core\Block\Adminhtml\System\Config;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Exception\LocalizedException;
use Droppery\Core\Helper\AbstractData;
use Droppery\Core\Helper\Validate;

/**
 * Class Button
 * @package Droppery\Core\Block\Adminhtml\System\Config
 */
class Button extends Field
{
    /**
     * @var string
     */
    protected $_template = 'system/config/button.phtml';

    /**
     * @var AbstractData
     */
    protected $_helper;

    /**
     * Button constructor.
     *
     * @param Context $context
     * @param Validate $helper
     * @param array $data
     */
    public function __construct(
        Context $context,
        Validate $helper,
        array $data = []
    ) {
        $this->_helper = $helper;

        parent::__construct($context, $data);
    }

    /**
     * @return string
     * @throws LocalizedException
     */
    public function getButtonHtml()
    {
        $activeButton = $this->getLayout()
            ->createBlock(\Magento\Backend\Block\Widget\Button::class)
            ->setData([
                'id'      => 'droppery_module_active',
                'label'   => __('Activate Now'),
                'onclick' => 'javascript:dropperyModuleActive(); return false;',
            ]);

        $cancelButton = $this->getLayout()
            ->createBlock(\Magento\Backend\Block\Widget\Button::class)
            ->setData([
                'id'      => 'droppery_module_update',
                'label'   => __('Update this license'),
                'onclick' => 'javascript:dropperyModuleUpdate(); return false;',
            ]);

        return $activeButton->toHtml() . $cancelButton->toHtml();
    }

    /**
     * Render button
     *
     * @param AbstractElement $element
     *
     * @return string
     */
    public function render(AbstractElement $element)
    {
        // Remove scope label
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();

        return parent::render($element);
    }

    /**
     * @return string
     */
    public function getButtonUrl()
    {
        return '';
    }

    /**
     * Return element html
     *
     * @param AbstractElement $element
     *
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        $originalData = $element->getOriginalData();
        $path = explode('/', $originalData['path']);
        $this->addData(
            [
                'droppery_is_active'       => $this->_helper->isModuleActive($originalData['module_name']),
                'droppery_module_name'     => $originalData['module_name'],
                'droppery_module_type'     => $originalData['module_type'],
                'droppery_active_url'      => $this->getUrl('mpcore/index/activate'),
                'droppery_free_config'     => Validate::jsonEncode($this->_helper->getConfigValue('free/module') ?: []),
                'droppery_module_html_id'  => implode('_', $path),
                'droppery_module_checkbox' => $this->_helper->getModuleCheckbox($originalData['module_name'])
            ]
        );

        return $this->_toHtml();
    }
}
