<?php

declare(strict_types=1);

namespace ReverseSeven\MagentoIndexersDemo\Model\Indexer\Demo;

use Magento\Framework\Indexer\ActionInterface;
use ReverseSeven\MagentoIndexersDemo\Model\Indexer\Demo\Action\Full;

class Price implements ActionInterface, \Magento\Framework\Mview\ActionInterface
{
    /**
     * @var Action\Full
     */
    private $demoPriceIndexerActionFull;

    /**
     * @param Action\Full $demoPriceIndexerActionFull
     */
    public function __construct(
        Full $demoPriceIndexerActionFull
    ) {
        $this->demoPriceIndexerActionFull = $demoPriceIndexerActionFull;
    }

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
        $this->demoPriceIndexerActionFull->execute();
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
