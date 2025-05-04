<?php
namespace DiskT\ThemeOptions\Model;

use Magento\Framework\Model\AbstractModel;
use DiskT\ThemeOptions\Model\ResourceModel\ThemeOptions as ThemeOptionsResource;

class ThemeOptions extends AbstractModel
{
    protected $_idFieldName = 'option_id'; // Nome do campo ID
    protected $_primaryKey = 'option_id';
    protected $_resourceModel = ThemeOptionsResource::class; // Ligação com o ResourceModel

    protected function _construct()
    {
        $this->_init('DiskT\ThemeOptions\Model\ResourceModel\ThemeOptions');
    }

    // Função para salvar as opções do tema
    public function saveThemeOptions($data)
    {
        try {
            // Aqui você pode configurar o que será salvo
            $this->setData($data);
            $this->save();
        } catch (\Exception $e) {
            // Log ou tratamento de erros aqui
            throw new \Exception('Erro ao salvar as configurações: ' . $e->getMessage());
        }
    }

    // Função para recuperar as opções do tema
    public function getThemeOptions()
    {
        return $this->getData();
    }
}
