<?php

namespace Currency\Mail\Model\ResourceModel\User;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Currency\Mail\Model\User', 'Currency\Mail\Model\ResourceModel\User');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>