<?php

declare(strict_types=1);

namespace ReverseSeven\MagentoIndexersDemo\Mview\View;

use Magento\Catalog\Model\Indexer\Product\Eav\Processor as ProductEavProcessor;
use Magento\Catalog\Model\Indexer\Product\Price\Processor as ProductPriceProcessor;
use Magento\CatalogRule\Model\Indexer\Product\ProductRuleProcessor;
use Magento\Framework\Mview\ViewInterface;
use ReverseSeven\MagentoIndexersDemo\Model\Indexer\Demo\Processor as DemoPriceProcessor;

class Subscription extends \Magento\Framework\Mview\View\Subscription
{
    /**
     * @var array
     */
    private $ignoreDemoPriceUpdateIndexers = [
        DemoPriceProcessor::INDEXER_ID,
        ProductRuleProcessor::INDEXER_ID,
        ProductPriceProcessor::INDEXER_ID,
        ProductEavProcessor::INDEXER_ID,
    ];

    /**
     * @inheritDoc
     */
    protected function buildStatement(string $event, ViewInterface $view): string
    {
        $statement = parent::buildStatement($event, $view);
        $changelog = $view->getChangelog();

        if (!in_array($changelog->getViewId(), $this->ignoreDemoPriceUpdateIndexers)) {
            return $statement;
        }

        // retrieve attribute ids
        // update $statement to ignore attribute ids based on current table and attribute backend table

        return $statement;
    }
}
