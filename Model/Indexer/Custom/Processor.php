<?php

declare(strict_types=1);

namespace ReverseSeven\MagentoIndexersDemo\Model\Indexer\Custom;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Indexer\AbstractProcessor;
use Magento\Framework\Indexer\IndexerRegistry;

class Processor extends AbstractProcessor
{
    const INDEXER_ID = 'custom_attribute_option';

    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * @param IndexerRegistry $indexerRegistry
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        IndexerRegistry $indexerRegistry,
        ResourceConnection $resourceConnection
    ) {
        parent::__construct(
            $indexerRegistry
        );

        $this->resourceConnection = $resourceConnection;
    }

    /**
     * @inheritDoc
     */
    public function reindexRow($id, $forceReindex = false)
    {
        if (!$forceReindex && $this->isIndexerScheduled()) {
            $this->schedule([$id]);
        }
        parent::reindexRow($id, $forceReindex);
    }

    /**
     * @inheritDoc
     */
    public function reindexList($ids, $forceReindex = false)
    {
        if (!$forceReindex && $this->isIndexerScheduled()) {
            $this->schedule($ids);
        }
        parent::reindexList($ids, $forceReindex);
    }

    /**
     * Schedule records for reindex
     *
     * @param int[] $ids
     */
    private function schedule(array $ids): void
    {
        $data = [];
        foreach ($ids as $id) {
            $data[] = ['entity_id' => $id];
        }

        $this->resourceConnection->getConnection()->insertMultiple(
            $this->resourceConnection->getConnection()->getTableName('custom_attribute_option_cl'),
            $data
        );
    }
}
