<?php

namespace Jeeva\Chez\Model\ResourceModel\Create;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Jeeva\Chez\Model\Create', 'Jeeva\Chez\Model\ResourceModel\Create');
        //$this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>