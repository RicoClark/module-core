<?php


namespace Droppery\Core\Model;

/**
 * Class Feed
 * @package Droppery\Core\Model
 */
class Feed extends \Magento\AdminNotification\Model\Feed
{
    /**
     * @inheritdoc
     */
    const DROPPERY_FEED_URL = 'www.droppery.com/notifications.xml';

    /**
     * @inheritdoc
     */
    public function getFeedUrl()
    {
        $httpPath = $this->_backendConfig->isSetFlag(self::XML_USE_HTTPS_PATH) ? 'https://' : 'http://';
        if ($this->_feedUrl === null) {
            $this->_feedUrl = $httpPath . self::DROPPERY_FEED_URL;
        }

        return $this->_feedUrl;
    }

    /**
     * @inheritdoc
     */
    public function checkUpdate()
    {
        if (!(boolean) $this->_backendConfig->getValue('droppery/general/notice_enable')) {
            return $this;
        }

        return parent::checkUpdate();
    }

    /**
     * @inheritdoc
     */
    public function getFeedData()
    {
        $type = $this->_backendConfig->getValue('droppery/general/notice_type');
        if (!$type) {
            return false;
        }

        $feedXml = parent::getFeedData();
        if ($feedXml && $feedXml->channel && $feedXml->channel->item) {
            $typeArray = explode(',', $type);
            $noteToRemove = [];

            foreach ($feedXml->channel->item as $item) {
                if (!in_array((string) $item->type, $typeArray)) {
                    $noteToRemove[] = $item;
                }
            }
            foreach ($noteToRemove as $item) {
                unset($item[0]);
            }
        }

        return $feedXml;
    }

    /**
     * @inheritdoc
     */
    public function getLastUpdate()
    {
        return $this->_cacheManager->load('droppery_notifications_lastcheck');
    }

    /**
     * @inheritdoc
     */
    public function setLastUpdate()
    {
        $this->_cacheManager->save(time(), 'droppery_notifications_lastcheck');

        return $this;
    }
}
