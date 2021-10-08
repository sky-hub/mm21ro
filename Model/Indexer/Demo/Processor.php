<?php

declare(strict_types=1);

namespace ReverseSeven\MagentoIndexersDemo\Model\Indexer\Demo;

use Magento\Framework\Indexer\AbstractProcessor;

class Processor extends AbstractProcessor
{
    const INDEXER_ID = 'demo_price';
}
