<?php


namespace Droppery\Core\Model\Config\Structure;

use Magento\Config\Model\Config\Structure\Data as StructureData;
use Droppery\Core\Block\Adminhtml\System\Config\Button;
use Droppery\Core\Block\Adminhtml\System\Config\Docs;
use Droppery\Core\Block\Adminhtml\System\Config\Form\Field\Version;
use Droppery\Core\Block\Adminhtml\System\Config\Message;
use Droppery\Core\Helper\Validate as Helper;

/**
 * Plugin to add 'Module Information' group to each modules (before general group)
 *
 * Class Data
 * @package Droppery\Core\Model\Config\Structure
 */
class Data
{
    /**
     * @var Helper
     */
    protected $_helper;

    /**
     * Data constructor.
     *
     * @param Helper $helper
     */
    public function __construct(Helper $helper)
    {
        $this->_helper = $helper;
    }

    /**
     * @param StructureData $object
     * @param array $config
     *
     * @return array
     */
    public function beforeMerge(StructureData $object, array $config)
    {
        if (!isset($config['config']['system'])) {
            return [$config];
        }

        /** @var array $sections */
        $sections = $config['config']['system']['sections'];
        foreach ($sections as $sectionId => $section) {
            if (isset($section['tab']) && ($section['tab'] === 'droppery') && ($section['id'] !== 'droppery')) {
                foreach ($this->_helper->getModuleList() as $moduleName) {
                    if ($section['id'] !== $this->_helper->getConfigModulePath($moduleName)) {
                        continue;
                    }

                    $dynamicGroups = $this->getDynamicConfigGroups($moduleName, $section['id']);
                    if (!empty($dynamicGroups)) {
                        $config['config']['system']['sections'][$sectionId]['children'] = $dynamicGroups + $section['children'];
                    }
                    break;
                }
            }
        }

        return [$config];
    }

    /**
     * @param $moduleName
     * @param $sectionName
     *
     * @return mixed
     */
    protected function getDynamicConfigGroups($moduleName, $sectionName)
    {
        $defaultFieldOptions = [
            'type'          => 'text',
            'showInDefault' => '1',
            'showInWebsite' => '0',
            'showInStore'   => '0',
            'sortOrder'     => 1,
            'module_name'   => $moduleName,
            'module_type'   => $this->_helper->getModuleType($moduleName),
            'validate'      => 'required-entry',
            '_elementType'  => 'field',
            'path'          => $sectionName . '/module'
        ];

        $type = $this->_helper->getModuleType($moduleName);
        $fields = [];
        foreach ($this->getFieldList() as $id => $option) {
            if (isset($option['show']) && $option['show'] !== $type) {
                continue;
            }

            $fields[$id] = array_merge($defaultFieldOptions, ['id' => $id], $option);
        }

        return [
            'module' => [
                'id'            => 'module',
                'label'         => __('Module Information'),
                'showInDefault' => '1',
                'showInWebsite' => '0',
                'showInStore'   => '0',
                '_elementType'  => 'group',
                'path'          => $sectionName,
                'children'      => $fields
            ]
        ];
    }

    /**
     * @return array
     */
    protected function getFieldList()
    {
        return [
            'docs'        => [
                'frontend_model' => Docs::class,
            ],
            'notice'      => [
                'frontend_model' => Message::class,
            ],
            'version'     => [
                'type'           => 'label',
                'label'          => __('Version'),
                'frontend_model' => Version::class,
            ],
            'name'        => [
                'label'          => __('Register Name'),
                'frontend_class' => 'droppery-module-active-field-free droppery-module-active-name',
                'show'           => Helper::MODULE_TYPE_FREE
            ],
            'email'       => [
                'label'          => __('Register Email'),
                'validate'       => 'required-entry validate-email',
                'frontend_class' => 'droppery-module-active-field-free droppery-module-active-email',
                'comment'        => __('This email will be used to create a new account at Droppery.com, Droppery help desk (to get priority support).'),
                'show'           => Helper::MODULE_TYPE_FREE
            ],
            'product_key' => [
                'label'          => __('Product Key'),
                'frontend_class' => 'droppery-module-active-field-key',
                'show'           => Helper::MODULE_TYPE_FREE
            ],
            'button'      => [
                'frontend_model' => Button::class,
                'show'           => Helper::MODULE_TYPE_FREE
            ]
        ];
    }
}
