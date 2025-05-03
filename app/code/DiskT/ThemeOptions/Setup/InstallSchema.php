<?php
namespace DiskT\ThemeOptions\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (!$setup->tableExists('diskt_themeoptions')) {
            $table = $setup->getConnection()->newTable(
                $setup->getTable('diskt_themeoptions')
            )->addColumn(
                'option_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Option ID'
            )->addColumn(
                'custom_css',
                Table::TYPE_TEXT,
                '2M',
                ['nullable' => true],
                'Custom CSS'
            )->setComment('Theme Options Table');

            $setup->getConnection()->createTable($table);
        }

        $setup->endSetup();
    }
}
