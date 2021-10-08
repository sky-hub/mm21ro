<?php

declare(strict_types=1);

namespace ReverseSeven\MagentoIndexersDemo\Model\Indexer\Demo\Action;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Config;
use Magento\Eav\Model\Entity\Attribute\AttributeInterface;
use Magento\Framework\App\ResourceConnection;

class Full
{
    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * @var Config
     */
    private $eavConfig;

    /**
     * @param ResourceConnection $resourceConnection
     * @param Config $eavConfig
     */
    public function __construct(
        ResourceConnection $resourceConnection,
        Config $eavConfig
    ) {
        $this->resourceConnection = $resourceConnection;
        $this->eavConfig = $eavConfig;
    }

    /**
     * Execute full reindex
     */
    public function execute()
    {
        $connection = $this->resourceConnection->getConnection();
        $demoPriceAttribute = $this->getAttributeByCode('demo_price');
        $attributeTable = $demoPriceAttribute->getBackendTable();
        $attributeId = $demoPriceAttribute->getAttributeId();

        $connection->delete($attributeTable, ['attribute_id = ?' => $attributeId]);

        $data = [];
        $productIds = $this->getProductIds();

//        foreach ($productIds as $productId) {
//            $data= [
//                'entity_id' => $productId,
//                'attribute_id' => $attributeId,
//                'value' => 100,
//            ];
//
//            $connection->insert($attributeTable, $data);
//        }

        // Performance tip: Reindex time can be improved by almost 20-25 sec. by using insertMultiple instead of insert
        foreach ($productIds as $productId) {
            $data[] = [
                'entity_id' => $productId,
                'attribute_id' => $attributeId,
                'value' => 100,
            ];
        }

        $connection->insertMultiple($attributeTable, $data);
    }

    /**
     * Retrieve product ids
     *
     * @return int[]
     */
    private function getProductIds(): array
    {
        $connection = $this->resourceConnection->getConnection();
        $select = $connection->select()->from(
            'catalog_product_entity',
            ['entity_id']
        );

        return $connection->fetchCol($select);
    }

    /**
     * Retrieves attribute by code
     *
     * @param string $attributeCode
     * @return AttributeInterface|null
     */
    private function getAttributeByCode(string $attributeCode): ?AttributeInterface
    {
        try {
            return $this->eavConfig->getAttribute(Product::ENTITY, $attributeCode);
        } catch (\Exception $e) {
            return null;
        }
    }
}
