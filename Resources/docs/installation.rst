Installing/Configuring
======================

Tags
~~~~

-  Use last unstable version ( alias of ``dev-master`` ) to stay always
   in last commit
-  Use last stable version tag to stay in a stable release.
-  |LatestUnstableVersion| |LatestStableVersion|

Installing `Gearman`_
~~~~~~~~~~~~~~~~~~~~~

To install Gearman Job Server with ``apt-get`` use the following
commands:

.. code-block:: bash

    $ sudo apt-get install gearman-job-server

And start server

.. code-block:: bash

    $ service gearman-job-server start

Then you need to install **Gearman driver** using the following commands:

- for PHP 5.x

.. code-block:: bash

    $ pecl install channel://pecl.php.net/gearman

- for PHP 7

.. code-block:: bash

    $ curl -L -o gearman.tgz https://github.com/wcgallego/pecl-gearman/archive/gearman-2.0.1.tar.gz
    $ tar -xzf gearman.tgz
    $ cd pecl-gearman-gearman-2.0.1 && phpize && ./configure && make && sudo make install

You will find all available gearman versions in `Pear Repository`_
Finally you need to start php module if it's not already made

.. code-block:: bash

    $ echo "extension=gearman.so" > /etc/php5/conf.d/gearman.ini

Installing `GearmanBundle`_
~~~~~~~~~~~~~~~~~~~~~~~~~~~

You have to add require line into you composer.json file

.. code-block:: yml

    "require": {
       "mikaelkael/gearman-bundle": "dev-master"
    }

Then you have to use composer to update your project dependencies

.. code-block:: bash

    $ curl -sS https://getcomposer.org/installer | php
    $ php composer.phar update

Register the GearmanBundle annotations in app/autoload.php

.. code-block:: php

    <?php
    // app/autoload.php
    AnnotationRegistry::registerFile(
        $kernel->locateResource(__DIR__ . '/../vendor/mikaelkael/GearmanBundle/Driver/Gearman/Work.php')
    );
    AnnotationRegistry::registerFile(
        $kernel->locateResource(__DIR__ . '/../vendor/mikaelkael/GearmanBundle/Driver/Gearman/Job.php')
    );


And register the bundle in your appkernel.php file

.. code-block:: php

    return array(
       // ...
       new Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle(),
       new Mkk\GearmanBundle\GearmanBundle(),
       // ...
    );

.. _Gearman: http://gearman.org
.. _Pear Repository: http://pecl.php.net/package/gearman
.. _GearmanBundle: https://github.com/mikaelkael/GearmanBundle

.. |LatestUnstableVersion| image:: https://poser.pugx.org/mikaelkael/gearman-bundle/v/unstable.png
   :target: https://packagist.org/packages/mikaelkael/gearman-bundle
.. |LatestStableVersion| image:: https://poser.pugx.org/mikaelkael/gearman-bundle/v/stable.png
   :target: https://packagist.org/packages/mikaelkael/gearman-bundle
