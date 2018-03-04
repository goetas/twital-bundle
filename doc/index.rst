What is TwitalBundle?
#####################

TwitalBundle is a Symfony_ bundle that integrates the Twital_ template engine into Synfony2.
This enables you to use all Twig/Symfony functionalities with the Twital template engine language syntax.

To learn more about Twital_, you can read the `dedicated documentation <http://twital.readthedocs.org/>`__.


Install
*******

The recommended way to install TwitalBundle is via Composer_:

.. code-block:: bash

    composer require 'goetas/twital-bundle'

If you are using SymfonyFlex_, the bundle will be automatically enabled
and configured, otherwise follow the next steps.

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

If you are using the symfony templating component (available in Symfony 2.x and 3.x):

.. code-block:: yaml

    framework:
        templating:
            engines: ['twig', 'twital']



If you are using SymfonyFlex_, the bundle is auto-configured.

Optional Configurations
***********************

Here are some optional configurations for the bundle.

Source Adapters
---------------

By default Twital parses ``*.html.twital``, ``*.xml.twital`` and ``*.xhtml.twital`` files. If you want you can
customize the file types automatically parsed by Twital.

.. code-block:: yaml

    goetas_twital:
        # extra file extension matching
        source_adapter:
            - { service: twital.source_adapter.xml, pattern: ['/\.xml\.twital$/', '/\.atom\.twital$/'] }
            - { service: twital.source_adapter.html5, pattern: ['/\.html\.twital$/', '/\.htm\.twital$/'] }
            - { service: twital.source_adapter.xhtml, pattern: ['/\.xhtml\.twital$/'] }



Twital comes with the following source adapters that you can use to parse your template files:

- ``twital.source_adapter.html5``: used for most of the HTML-style templates
- ``twital.source_adapter.xml``: used for strictly XML-compliant templates
- ``twital.source_adapter.xhtml``: used for strictly XHTML-compliant templates (similar to XML but with some XHTML customizations)

Full Twig Compatibility
-----------------------
The following template is a valid Twig template, but is not a valid HTML5 document (the ``div`` tag can contain only
attributes). Because of it, the Twital source adapters will not be able to parse the template.

.. code-block:: xml+jinja

    <div {% if foo %} class="row" {% endif %}>
        Hello World
    </div>


You can also enable a full Twig compatibility mode to allow this kind of templates.

.. code-block:: yaml

    goetas_twital:
        full_twig_compatibility: true

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
.. _Symfony: http://symfony.com
.. _Composer: https://getcomposer.org/
.. _SymfonyFlex: https://github.com/symfony/flex
