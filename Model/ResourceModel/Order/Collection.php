<?php

namespace Unicommerce\ExportJob\Model\ResourceModel\Order;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Order Resource Model Collection
 *
 * @author      GreenHonchos
 */
class Collection extends AbstractCollection
{
    /**
     * Initialize resource collection
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('Unicommerce\ExportJob\Model\Order', 'Unicommerce\ExportJob\Model\ResourceModel\Order');
    }
}
