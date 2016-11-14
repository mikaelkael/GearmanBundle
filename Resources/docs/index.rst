GearmanBundle Documentation
===========================

|BuildStatus| |ScrutinizerQualityScore| |LatestStableVersion| |LatestUnstableVersion| |License| |TotalDownloads|

GearmanBundle is a bundle for Symfony2 or Symfony 3 intended to provide an easy way to
support developers who need to use job queues. For example: mail queues, Solr
generation queues or Database upload queues.

.. _dev-docs:

User Documentation
------------------

.. toctree::
    :maxdepth: 2

    installation
    configuration
    definition_workers
    running_jobs
    client
    kernel_events
    customize
    cache
    contributing
    faqs

.. _site-docs

CookBook
--------

.. toctree::
    :maxdepth: 2

    cookbook/job_status


.. |BuildStatus| image:: https://travis-ci.org/mikaelkael/GearmanBundle.png?branch=master
   :target: https://travis-ci.org/mikaelkael/GearmanBundle
.. |ScrutinizerQualityScore| image:: https://scrutinizer-ci.com/g/mikaelkael/GearmanBundle/badges/coverage.png?b=master
   :target: https://scrutinizer-ci.com/g/mikaelkael/GearmanBundle/?branch=master
.. |LatestStableVersion| image:: https://poser.pugx.org/mikaelkael/gearman-bundle/v/stable.png
   :target: https://packagist.org/packages/mikaelkael/gearman-bundle
.. |LatestUnstableVersion| image:: https://poser.pugx.org/mikaelkael/gearman-bundle/v/unstable.png
   :target: https://packagist.org/packages/mikaelkael/gearman-bundle
.. |License| image:: https://poser.pugx.org/mikaelkael/gearman-bundle/license.png
   :target: https://packagist.org/packages/mikaelkael/gearman-bundle
.. |TotalDownloads| image:: https://poser.pugx.org/mikaelkael/gearman-bundle/downloads.png
   :target: https://packagist.org/packages/mikaelkael/gearman-bundle