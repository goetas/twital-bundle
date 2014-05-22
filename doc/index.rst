What is TwitalBundle?
#####################

TwitalBundle is a Symfony2_ bundle that integrates the Twital_ template engine into Synfony2.
This enables you to use all Twig/Symfony2 functionalities with the Twital template engine language syntax.

To learn more about Twital_, you can read the `dedicated documentation <http://twital.readthedocs.org/>`__.


Install
*******

There are two recommended ways to install TwitalBundle via Composer_:

* using the ``composer require`` command:

.. code-block:: bash

    composer require 'goetas/twital-bundle:*'

* adding the dependency to your ``composer.json`` file:

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

In order to make it work, you have to enable the ``twital`` template engine inside your ``config.yml``.

.. code-block:: yaml

    framework:
        templating:
            engines: ['twig', 'twital']
            
    #optional configurations used for file extension matching 
    goetas_twital:
        source_adapter:
            - { service: twital.source_adapter.xml, pattern: ['/\.xml\.twital$/', '/\.atom\.twital$/'] }
            - { service: twital.source_adapter.html, pattern: ['/\.html\.twital$/', '/\.htm\.twital$/'] }
            - { service: twital.source_adapter.xhtml, pattern: ['/\.xhtml\.twital$/'] }    

Integration
***********

``TwitalBundle`` comes with all features that are already supported by TwigBundle_ 
(forms, translations, assetic, routing, etc).  
  

Contributing
************

This is an open source project - contributions are welcome. If your are interested,
you can contribute to documentation, source code, test suite or anything else!

To start contributing right now, go to https://github.com/goetas/twital-bundle and fork
it!

You can read some tips to improve your contributing experience looking into https://github.com/goetas/twital-bundle/blob/master/CONTRIBUTING.md 
present inside the root directory of Twital GIT repository. 


  
Contents
********

.. toctree::
:hidden:
    :maxdepth: 2
    
    extension
    loader
    tags/index
    

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
