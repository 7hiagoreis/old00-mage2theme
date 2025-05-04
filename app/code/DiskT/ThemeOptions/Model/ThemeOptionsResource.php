<?php
namespace DiskT\ThemeOptions\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ThemeOptions extends AbstractDb
{
    protected function _construct()
    {
        // Definindo a tabela no banco de dados
        $this->_init('diskt_theme_options', 'option_id'); // 'diskt_theme_options' é a tabela e 'option_id' é a chave primária
    }
}
