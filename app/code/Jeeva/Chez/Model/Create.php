<?php
namespace Jeeva\Chez\Model;

class Create extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Jeeva\Chez\Model\ResourceModel\Create');
    }
}
?>