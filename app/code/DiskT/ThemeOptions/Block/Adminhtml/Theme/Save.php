<?php
namespace DiskT\ThemeOptions\Block\Adminhtml\Theme;

use Magento\Backend\Block\Template;

class Edit extends Template
{
    /**
     * Verifica se a cor é editável.
     *
     * @return bool
     */
    public function isCorEditable()
    {
        return true; // ou lógica personalizada
    }

    /**
     * Verifica se o botão é editável.
     *
     * @return bool
     */
    public function isBotaoEditable()
    {
        return true; // ou lógica personalizada
    }
}
