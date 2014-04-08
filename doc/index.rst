What is TwitalBundle?
#####################

TwitalBundle is a `Symfony2`_ bundle that integrates `Twital`_ template engine into Synfony2.
This enables you to use all Twig/Symfony2 functionalities with Twital template engine language syntax.

To learn more about Twital, you can read the  `dedicated documentation <http://twital.readthedocs.org/>`__.


Install
*******

The recommended way to install ``TwitalBundle`` is via Composer_.

Using  ``composer require`` command

.. code-block:: bash

    composer require 'goetas/twital-bundle:*'

Or adding its dependency to your ``composer.json`` file

.. code-block:: js

    "require": {
        ..
        "goetas/twital-bundle": "*",
        ..
    }


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

In order to make it work you have to enable ``twital`` template engine inside your ``config.yml``.

.. code-block:: yaml

    framework:
        templating:
            engines: ['twig', 'twital']
            
    #optional configurations for file extension matching 
    goetas_twital:
        source_adapter:
            twital.source_adapter.xml: ['/\.xml\.twital$/', '/\.atom\.twital$/']
            twital.source_adapter.html: ['/\.html\.twital$/', '/\.htm\.twital$/']
            twital.source_adapter.xhtml: ['/\.xhtml\.twital$/']

Integration
***********

``TwitalBundle`` comes with all features that are already supported by TwigBundle_ 
(forms, translations, assetic, routing, etc).  
    
Contents
********

.. toctree::
    :maxdepth: 3
    
    extension
    loader
    tags/index
    

Contributing
************

This is a open source project, contributions are welcome. If your are interested,
you can contribute to documentation, source code, test suite or anything else!

To start contributing right now, go to https://github.com/goetas/twital-bundle and fork
it!

You can read some tips to improve you contributing experience looking into https://github.com/goetas/twital-bundle/blob/master/CONTRIBUTING.md 
present inside the root directory of Twital GIT repository. 


Note
****

I'm sorry for the *terrible* english fluency used inside the documentation, I'm trying to improve it. 
Pull Requests are welcome.


.. _Twig: http://twig.sensiolabs.org/
.. _TwitalBundle: https://github.com/goetas/twital-bundle
.. _TwigBundle: https://github.com/symfony/TwigBundle
.. _Twital: https://github.com/goetas/twital
.. _Symfony2: http://symfony.com
.. _Composer: https://getcomposer.org/