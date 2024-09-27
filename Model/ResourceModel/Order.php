<?php

namespace Unicommerce\ExportJob\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Order Resource Model
 *
 * @author      GreenHonchos
 */
class Order extends AbstractDb
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('unicommerce_api_data', 'entity_id');
    }
}