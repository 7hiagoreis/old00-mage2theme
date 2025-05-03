# 🖴 Old00 Magento 2 Theme

Tema personalizado para Magento 2 desenvolvido para facilitar a personalização visual diretamente pelo painel administrativo, sem necessidade de editar arquivos CSS ou LESS.

---

## 📦 Instalação

### Manual (via FTP ou SSH)

1. Copie a pasta `app/code/DiskT/ThemeOptions` para o seu projeto Magento.
2. Copie o tema para `app/design/frontend/DiskT/old00`.

### Depois, execute os comandos no terminal Magento:

```bash
bin/magento module:enable DiskT_ThemeOptions
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento setup:static-content:deploy -f
bin/magento cache:flush


⚠️ Este tema ainda está em desenvolvimento e pode conter erros ou funcionalidades incompletas.
