<?php

namespace DiskT\ThemeOptions\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Cache\Frontend\Pool;

class Save extends Action
{
    protected $configWriter;
    protected $resultRedirectFactory;
    protected $storeManager;
    protected $cacheTypeList;
    protected $cacheFrontendPool;

    public function __construct(
        Action\Context $context,
        WriterInterface $configWriter,
        RedirectFactory $resultRedirectFactory,
        StoreManagerInterface $storeManager,
        TypeListInterface $cacheTypeList,
        Pool $cacheFrontendPool
    ) {
        parent::__construct($context);
        $this->configWriter = $configWriter;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->storeManager = $storeManager;
        $this->cacheTypeList = $cacheTypeList;
        $this->cacheFrontendPool = $cacheFrontendPool;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();

        if (!empty($data)) {
            try {
                $storeId = $this->storeManager->getStore()->getId();
                $theme = $this->getRequest()->getParam('theme') ?? 'default';

                if (isset($data['modo_hacker'])) {
                    $modoHacker = $data['modo_hacker'];

                    if ($modoHacker == '1') {
                        $this->configWriter->save("diskt_theme/$theme/background_color", '#000000', 'stores', $storeId);
                        $this->configWriter->save("diskt_theme/$theme/font_color", '#ffffff', 'stores', $storeId);
                        $this->configWriter->save("diskt_theme/$theme/link_color", '#00ff00', 'stores', $storeId);
                    } elseif ($modoHacker == '0') {
                        $this->configWriter->save("diskt_theme/$theme/background_color", '#ffffff', 'stores', $storeId);
                        $this->configWriter->save("diskt_theme/$theme/font_color", '#000000', 'stores', $storeId);
                        $this->configWriter->save("diskt_theme/$theme/link_color", '#0000ff', 'stores', $storeId);
                    }

                    $this->configWriter->save("diskt_theme/$theme/hacker_mode", $modoHacker, 'stores', $storeId);
                }

                if (!empty($data['cor_principal'])) {
                    $this->configWriter->save("diskt_theme/$theme/background_color", $data['cor_principal'], 'stores', $storeId);
                }

                if (!empty($data['cor_fonte'])) {
                    $this->configWriter->save("diskt_theme/$theme/font_color", $data['cor_fonte'], 'stores', $storeId);
                }

                if (!empty($data['cor_link'])) {
                    $this->configWriter->save("diskt_theme/$theme/link_color", $data['cor_link'], 'stores', $storeId);
                }

                if (!empty($data['font_family'])) {
                    $this->configWriter->save("diskt_theme/$theme/font_family", $data['font_family'], 'stores', $storeId);
                }

                $this->flushCache();
                $this->messageManager->addSuccessMessage(__('As configurações foram salvas com sucesso.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Erro ao salvar: ' . $e->getMessage()));
            }
        } else {
            $this->messageManager->addErrorMessage(__('Nenhuma configuração foi alterada.'));
        }

        return $resultRedirect->setPath('adminhtml/system_config/edit/section/diskt_theme');
    }

    private function flushCache()
    {
        $cacheTypes = ['config', 'block_html', 'full_page'];
        foreach ($cacheTypes as $cacheType) {
            $this->cacheTypeList->cleanType($cacheType);
        }

        foreach ($this->cacheFrontendPool as $cacheFrontend) {
            $cacheFrontend->getBackend()->clean();
        }
    }
}
