<?php
namespace DiskT\ThemeOptions\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\Controller\Result\RedirectFactory;

class Save extends Action
{
    protected $configWriter;
    protected $resultRedirectFactory;

    public function __construct(
        Action\Context $context,
        WriterInterface $configWriter,
        RedirectFactory $resultRedirectFactory
    ) {
        parent::__construct($context);
        $this->configWriter = $configWriter;
        $this->resultRedirectFactory = $resultRedirectFactory;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();

        if (!empty($data)) {
            try {
                // Verifica se o modo Hacker foi enviado
                if (isset($data['modo_hacker'])) {
                    $modoHacker = $data['modo_hacker'];

                    if ($modoHacker == '1') {
                        // Tema escuro (modo hacker)
                        $this->configWriter->save('diskt_theme/general/background_color', '#000000', 'default', 0);
                        $this->configWriter->save('diskt_theme/general/font_color', '#ffffff', 'default', 0);
                        $this->configWriter->save('diskt_theme/general/link_color', '#00ff00', 'default', 0);
                    } elseif ($modoHacker == '0') {

                        // Tema claro (modo clean)
                        $this->configWriter->save('diskt_theme/general/background_color', '#ffffff', 'default', 0);
                        $this->configWriter->save('diskt_theme/general/font_color', '#000000', 'default', 0);
                        $this->configWriter->save('diskt_theme/general/link_color', '#0000ff', 'default', 0);
                    }

                    // Sempre salva o valor do modo hacker
                    $this->configWriter->save('diskt_theme/general/hacker_mode', $modoHacker, 'default', 0);
                }

                // Sobrescreve com valores personalizados, se enviados
                if (!empty($data['cor_principal'])) {
                    $this->configWriter->save('diskt_theme/general/background_color', $data['cor_principal'], 'default', 0);
                }

                if (!empty($data['cor_fonte'])) {
                    $this->configWriter->save('diskt_theme/general/font_color', $data['cor_fonte'], 'default', 0);
                }

                if (!empty($data['cor_link'])) {
                    $this->configWriter->save('diskt_theme/general/link_color', $data['cor_link'], 'default', 0);
                }

                if (!empty($data['cor_botao_primario'])) {
                    $this->configWriter->save('diskt_theme/general/button_color', $data['cor_botao_primario'], 'default', 0);
                }

                if (!empty($data['cor_link_botao'])) {
                    $this->configWriter->save('diskt_theme/general/link_button_color', $data['cor_link_botao'], 'default', 0);
                }

                if (!empty($data['font_family'])) {
                    $this->configWriter->save('diskt_theme/general/font_family', $data['font_family'], 'default', 0);
                }

                $this->messageManager->addSuccessMessage(__('As configurações foram salvas com sucesso.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Erro ao salvar: ' . $e->getMessage()));
            }
        } else {
            $this->messageManager->addErrorMessage(__('Nenhuma configuração foi alterada.'));
        }

        return $resultRedirect->setPath('adminhtml/system_config/edit/section/diskt_theme');
    }
}
