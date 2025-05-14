<?php

namespace DiskT\ThemeOptions\Block\Adminhtml\Theme;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\ResourceConnection;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\State as AppState;
use Magento\Framework\App\Cache\Manager as CacheManager;

class Edit extends Template
{
    protected $resourceConnection;
    protected $storeManager;
    protected $scopeConfig;
    protected $_appState;
    protected $_cacheManager;

    public function __construct(
        Template\Context $context,
        ResourceConnection $resourceConnection,
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig,
        AppState $appState,
        CacheManager $cacheManager,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->resourceConnection = $resourceConnection;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
        $this->_appState = $appState;
        $this->_cacheManager = $cacheManager;

        // Limpar cache de configuração se estiver em modo desenvolvedor
        if ($this->_appState->getMode() === AppState::MODE_DEVELOPER) {
            $this->_cacheManager->clean(['config']);
        }
    }

    private function getSelectedTheme()
    {
        $storeId = $this->storeManager->getStore()->getId();
        
        // Primeiro tenta pelo ScopeConfig
        $themeSelecionado = $this->scopeConfig->getValue(
            'diskt_theme/general/selected_theme',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );
        
        // Se não encontrou, tenta direto no banco
        if (empty($themeSelecionado)) {
            $connection = $this->resourceConnection->getConnection();
            $sql = "SELECT value FROM core_config_data 
                    WHERE path = 'diskt_theme/general/selected_theme' 
                    AND scope = 'stores' 
                    AND scope_id = :store_id 
                    ORDER BY config_id DESC LIMIT 1";
            
            $themeSelecionado = $connection->fetchOne($sql, ['store_id' => $storeId]);
        }
        
        error_log("Tema carregado no backend: " . $themeSelecionado);
        
        return $themeSelecionado ?: 'Old00_Hacker'; // Valor padrão caso não encontre
    }

    private function getConfigValue($path)
    {
        $storeId = $this->storeManager->getStore()->getId();
        $theme = $this->getSelectedTheme();
        
        // Primeiro tenta pelo ScopeConfig
        $value = $this->scopeConfig->getValue(
            "diskt_theme/$theme/$path",
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );
        
        // Se não encontrou, tenta direto no banco
        if (empty($value)) {
            $connection = $this->resourceConnection->getConnection();
            $sql = "SELECT value FROM core_config_data 
                    WHERE path = :path 
                    AND scope = 'stores' 
                    AND scope_id = :store_id 
                    ORDER BY config_id DESC LIMIT 1";
            
            $value = $connection->fetchOne($sql, [
                'path' => "diskt_theme/$theme/$path", 
                'store_id' => $storeId
            ]);
        }
        
        error_log("Configuração carregada ($path) para tema $theme: " . $value);
        
        return $value;
    }

    public function getModoHacker()
    {
        return $this->getConfigValue('hacker_mode');
    }

    public function getBackgroundColor()
    {
        return $this->getConfigValue('background_color');
    }

    public function getFontColor()
    {
        return $this->getConfigValue('font_color');
    }

    public function getLinkColor()
    {
        return $this->getConfigValue('link_color');
    }

    public function getFontFamily()
    {
        return $this->getConfigValue('font_family');
    }

    public function getButtonColor()
    {
        return $this->getConfigValue('botao_primario');
    }

    public function getLinkButtonColor()
    {
        return $this->getConfigValue('cor_link_botao');
    }
}