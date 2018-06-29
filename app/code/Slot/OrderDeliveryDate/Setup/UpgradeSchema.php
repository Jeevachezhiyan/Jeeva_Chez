<?php
namespace Bss\OrderDeliveryDate\Setup;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
        /**
         * {@inheritdoc}
         */
        public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
        {
                $installer = $setup;
                $installer->startSetup();
//              if (version_compare($context->getVersion(), '1.1.4') < 0) {
                        $installer->getConnection()->addColumn($installer->getTable('quote'), 'shipping_delivered_date', 'date');
                        $installer->getConnection()->addColumn($installer->getTable('sales_order'), 'shipping_delivered_date', 'date');
//              }
                $setup->endSetup();
        }
}

