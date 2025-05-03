<?php
namespace DiskT\ThemeOptions\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\App\Config\Storage\WriterInterface;

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

        if ($data) {
            try {
                if (isset($data['modo_hacker'])) {
                    $this->configWriter->save('themeoptions/settings/modo_hacker', $data['modo_hacker']);
                }
                $this->messageManager->addSuccessMessage(__('Configurações salvas com sucesso.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Erro ao salvar: ' . $e->getMessage()));
            }
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index');
    }
}
