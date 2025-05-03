<?php

namespace DiskT\ThemeOptions\Setup;

use Magento\Framework\Setup\UninstallInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UninstallSchema implements UninstallInterface
{
    /**
     * {@inheritdoc}
     */
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        // Deleta a tabela 'diskt_themeoptions' ao desinstalar o módulo
        $setup->getConnection()->dropTable($setup->getTable('diskt_themeoptions'));
    }
}
