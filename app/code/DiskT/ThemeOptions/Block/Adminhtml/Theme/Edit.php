<?php
namespace DiskT\ThemeOptions\Block\Adminhtml\Theme;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Edit extends Template
{
    protected $scopeConfig;

    public function __construct(
        Template\Context $context,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->scopeConfig = $scopeConfig;
    }

    public function getBackgroundColor()
    {
        return $this->scopeConfig->getValue('diskt_theme/general/background_color', \Magento\Store\Model\ScopeInterface::SCOPE_STORE) ?? '#000000';
    }

    public function getFontColor()
    {
        return $this->scopeConfig->getValue('diskt_theme/general/font_color', \Magento\Store\Model\ScopeInterface::SCOPE_STORE) ?? '#333333';
    }

    public function getLinkColor()
    {
        return $this->scopeConfig->getValue('diskt_theme/general/link_color', \Magento\Store\Model\ScopeInterface::SCOPE_STORE) ?? '#0000EE';
    }

    public function getModoHacker()
    {
        return $this->scopeConfig->getValue('diskt_theme/general/hacker_mode', \Magento\Store\Model\ScopeInterface::SCOPE_STORE) ?? 'custom';
    }

    public function getFontFamily()
    {
        return $this->scopeConfig->getValue('diskt_theme/general/font_family', \Magento\Store\Model\ScopeInterface::SCOPE_STORE) ?? 'Arial, sans-serif';
    }

    public function isCorEditable()
    {
        return $this->getModoHacker() === 'custom';
    }

    public function debugConfig()
    {
        echo '<pre>';
        var_dump([
            'background_color' => $this->getBackgroundColor(),
            'font_color' => $this->getFontColor(),
            'link_color' => $this->getLinkColor(),
            'modo_hacker' => $this->getModoHacker(),
            'font_family' => $this->getFontFamily(),
        ]);
        echo '</pre>';
        exit; // 🔥 Remova isso após testar!
    }
}
