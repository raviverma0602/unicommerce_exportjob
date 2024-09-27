<?php

namespace Unicommerce\ExportJob\Model;

use Magento\Cron\Exception;
use Magento\Framework\Model\AbstractModel;

/**
 * Order Model
 *
 * @author      GreenHonchos
 */
class Order extends AbstractModel
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Unicommerce\ExportJob\Model\ResourceModel\Order::class);
    }
    
}