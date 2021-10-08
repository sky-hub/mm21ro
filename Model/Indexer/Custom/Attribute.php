<?php

declare(strict_types=1);

namespace ReverseSeven\MagentoIndexersDemo\Model\Indexer\Custom;

use Magento\Framework\Indexer\ActionInterface;

class Attribute implements ActionInterface, \Magento\Framework\Mview\ActionInterface
{
    /**
     * @inheritDoc
     */
    public function execute($ids)
    {
    }

    /**
     * @inheritDoc
     */
    public function executeFull()
    {
        sleep(10); // added to demonstrate how shared indexers logic works
    }

    /**
     * @inheritDoc
     */
    public function executeList(array $ids)
    {
    }

    /**
     * @inheritDoc
     */
    public function executeRow($id)
    {
    }
}
