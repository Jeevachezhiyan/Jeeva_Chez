<?php
namespace Currency\Mail\Model\ResourceModel;

class User extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('user_management', 'id');
    }
}
?>