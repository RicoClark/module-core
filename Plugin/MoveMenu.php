<?php


namespace Droppery\Core\Plugin;

use Magento\Backend\Model\Menu\Builder\AbstractCommand;
use Droppery\Core\Helper\AbstractData;

/**
 * Class MoveMenu
 * @package Droppery\Core\Plugin
 */
class MoveMenu
{
    const DROPPERY_CORE = 'Droppery_Core::menu';

    /**
     * @var AbstractData
     */
    protected $helper;

    /**
     * MoveMenu constructor.
     *
     * @param AbstractData $helper
     */
    public function __construct(AbstractData $helper)
    {
        $this->helper = $helper;
    }

    /**
     * @param AbstractCommand $subject
     * @param $itemParams
     *
     * @return mixed
     */
    public function afterExecute(AbstractCommand $subject, $itemParams)
    {
        if ($this->helper->getConfigGeneral('menu')) {
            if (strpos($itemParams['id'], 'Droppery_') !== false
                && isset($itemParams['parent'])
                && strpos($itemParams['parent'], 'Droppery_') === false) {
                $itemParams['parent'] = self::DROPPERY_CORE;
            }
        } elseif ((isset($itemParams['id']) && $itemParams['id'] === self::DROPPERY_CORE)
                || (isset($itemParams['parent']) && $itemParams['parent'] === self::DROPPERY_CORE)) {
            $itemParams['removed'] = true;
        }

        return $itemParams;
    }
}
