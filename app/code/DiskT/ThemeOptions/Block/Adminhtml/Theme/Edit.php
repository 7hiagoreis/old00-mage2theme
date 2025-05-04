<?php
namespace DiskT\ThemeOptions\Block\Adminhtml\Theme;

use Magento\Backend\Block\Template;

class Edit extends Template
{
    public function getFormAction()
    {
        return $this->getUrl('*/*/save');
    }

    public function getCorPrincipal()
    {
        return '#000000'; // buscar do config do Tema
    }

    public function getHexCorPrincipal()
    {
        return '#ffffff';
    }

    public function getCorLink()
    {
        return '#0000ff';
    }

    public function getHexCorLink()
    {
        return '#0000ff';
    }

    public function getCorFonte()
    {
        return '#333333';
    }

    public function getHexCorFonte()
    {
        return '#333333';
    }

    public function getCorBotaoPrimario()
    {
        return '#007bff';
    }

    public function getHexCorBotaoPrimario()
    {
        return '#007bff';
    }

    public function getCorLinkBotao()
    {
        return '#ffffff';
    }

    public function getHexCorLinkBotao()
    {
        return '#ffffff';
    }

    public function getCorVoltarTopo()
    {
        return '#0000ff';
    }

    public function getHexCorVoltarTopo()
    {
        return '#0000ff';
    }

    public function getMostrarVoltarTopo()
    {
        return '1';
    }

    public function getModoHacker()
    {
        return 'custom'; // ou '1', '0' conforme lógica
    }

    // 🔧 MÉTODOS 

    public function isCorEditable()
    {
        return $this->getModoHacker() === 'custom';
    }

    public function isBotaoEditable()
    {
        return $this->getModoHacker() === 'custom';
    }

    public function isVoltarTopoEditable()
    {
        return $this->getMostrarVoltarTopo() === '1';
    }
}
