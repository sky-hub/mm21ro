<?php

declare(strict_types=1);

namespace ReverseSeven\MagentoIndexersDemo\Controller\Adminhtml\Product\Attribute;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Config as EavConfig;
use Magento\Eav\Model\Entity\Attribute\AttributeInterface;
use Magento\Framework\App\Action\HttpGetActionInterface;
use MyCompany\MyModule\Model\Indexer\Custom\Processor;

/**
 * Action class used only to demonstrate how an attribute id can be added to the changelog table without subscriptions
 */
class Schedule extends Action implements HttpGetActionInterface
{
    /**
     * @var Processor
     */
    private $customIndexProcessor;

    /**
     * @var EavConfig
     */
    private $eavConfig;

    /**
     * @param Context $context
     * @param Processor $customIndexProcessor
     * @param EavConfig $eavConfig
     */
    public function __construct(
        Context $context,
        Processor $customIndexProcessor,
        EavConfig $eavConfig
    ) {
        parent::__construct($context);
        $this->customIndexProcessor = $customIndexProcessor;
        $this->eavConfig = $eavConfig;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        $attributeId = $this->getAttributeByCode('demo_price')->getAttributeId();
        $this->customIndexProcessor->reindexRow($attributeId);

        $this->messageManager->addSuccessMessage(
            __('Your attribute change has been scheduled.')
        );

        return $resultRedirect->setPath('admin/dashboard');
    }

    /**
     * Retrieves attribute by code
     *
     * @param string $attributeCode
     * @return AttributeInterface|null
     */
    private function getAttributeByCode(string $attributeCode)
    {
        try {
            return $this->eavConfig->getAttribute(Product::ENTITY, $attributeCode);
        } catch (\Exception $e) {
            return null;
        }
    }
}
