<?php

namespace Jeeva\Chez\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        
        if (version_compare($context->getVersion(), '1.0.2', '<')) {
              $setup->startSetup();

        //$quote = 'quote';
        $orderTable = 'customer_information_table';

        //Order table
 
        $setup->getConnection()    
              ->addColumn(
                $setup->getTable($orderTable),
                'middle_name',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'Middle Name'
                ]
            );


    
        $setup->endSetup();
      
        }
    }
}
