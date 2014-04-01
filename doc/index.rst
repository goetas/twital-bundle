What is TwitalBundle?
#####################

TwitalBundle is a Symfony2_ bundle that integrates Twital_ template engine into Synfony2.

To learn more about Twital_, you can read the  `dedicated documentation <http://twital.readthedocs.org/>`__.

TwitalBundle enables you to use all Twig/Symfony2 functionaties with Twital template engine language syntax.


Prerequisites
*************

Twital needs at least **Symfony 2.2** and **Twig 2.4** to run.

Install
*******

The recommended way to install Twig is via Composer.

Using  ``composer require`` command

.. code-block:: bash

    composer require goetas/twital-bundle:1.0.*

Or adding its dependency to your ``composer.json`` file

.. code-block:: js

    "require": {
        ..
        "goetas/twital-bundle":"1.0.*",
        ..
    }

.. note::

    To learn more about composer please refer to its original site (https://getcomposer.org/).


Enable the bundle
*****************

To enable the bundle in the kernel:

.. code-block:: php

    <?php
    // app/AppKernel.php
    
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Goetas\TwitalBundle\GoetasTwitalBundle(),
            //..
        );
    }

Configure
*********

.. code-block:: yml

    framework:
        templating:
            engines: ['twig', 'twital']
            
    
Contents
********

.. toctree::
    :maxdepth: 3
    
    extension
    loader
    

Contributing
************

This is a open source project, contributions are welcome. If your are interested,
you can contribute to documentation, source code, test suite or anything else!

To start contributing right now, go to https://github.com/goetas/twital-bundle and fork
it!

You can read some tips to improve you contributing experience looking into https://github.com/goetas/twital/blob/master/CONTRIBUTING.md 
present inside the root directory of Twital git repository. 
