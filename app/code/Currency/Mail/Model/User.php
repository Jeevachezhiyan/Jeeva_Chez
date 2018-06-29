<?php
namespace Currency\Mail\Model;

class User extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Currency\Mail\Model\ResourceModel\User');
    }
}
?>