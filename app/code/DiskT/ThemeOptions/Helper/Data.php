<?php
namespace DiskT\ThemeOptions\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\ResourceConnection;

class Data extends AbstractHelper
{
    protected $resource;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        ResourceConnection $resource
    ) {
        $this->resource = $resource;
        parent::__construct($context);
    }

    public function getThemeOptions()
    {
        $connection = $this->resource->getConnection();
        $tableName = $this->resource->getTableName('diskt_themeoptions');
        $select = $connection->select()->from($tableName)->limit(1);
        return $connection->fetchRow($select);
    }
}
