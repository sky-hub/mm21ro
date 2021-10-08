#Magento Indexers Demo

This module is a demo and it is provided just as a reference to understand better how Magento indexers work and how they can be implemented.


###Demonstrates:
- How to implement shared indexers
- How to create dependency between indexers
- How to update changelog table without mview subscriptions
- How to update triggers to ignore certain attribute changes when adding values to changelog tables
- How can indexer performance can be improved by using `insertMultiple` instead of `insert`


###Pre-requisites:
- Magento 2.4.3
- Magento Sample Data: https://devdocs.magento.com/guides/v2.4/install-gde/install/sample-data-after-composer.html
