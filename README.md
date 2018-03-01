[![Build Status](https://travis-ci.org/goetas/twital-bundle.png?branch=dev)](https://travis-ci.org/goetas/twital-bundle)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/goetas/twital-bundle/badges/quality-score.png)](https://scrutinizer-ci.com/g/goetas/twital-bundle/)
[![Code Coverage](https://scrutinizer-ci.com/g/goetas/twital-bundle/badges/coverage.png)](https://scrutinizer-ci.com/g/goetas/twital-bundle/)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/goetas/twital-bundle/master/LICENSE)
[![Packagist](https://img.shields.io/packagist/v/goetas/twital-bundle.svg)](https://packagist.org/packages/goetas/twital-bundle)

TwitalBundle (Twital with Symfony)
===================================


TwitalBundle is a [Symfony](http://symfony.com/) bundle that integrates the [Twital](https://github.com/goetas/twital/) template engine into Synfony2 framework.
This enables you to use all Twig/Symfony functionalities with the Twital template engine language syntax.

To learn more about Twital, you can read the [dedicated documentation](http://twital.readthedocs.org/).



Install
-------

The recommended way to install TwitalBundle is using [Composer](https://getcomposer.org/):

```bash
composer require 'goetas/twital-bundle'
```

Enable the bundle
-----------------

To enable the bundle in the kernel:

```php
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
```

Configure
---------

In order to make it work, you have to enable the ``twital`` template engine inside your ``config.yml``.


```yaml
framework:
    templating:
        engines: ['twig', 'twital']
        
#optional configurations for file extension matching 
goetas_twital:
    source_adapter:
        - { service: twital.source_adapter.xml, pattern: ['/\.xml\.twital$/', '/\.atom\.twital$/'] }
        - { service: twital.source_adapter.html, pattern: ['/\.html\.twital$/', '/\.htm\.twital$/'] }
        - { service: twital.source_adapter.xhtml, pattern: ['/\.xhtml\.twital$/'] }    
```
Documentation
-------------

Go here http://twitalbundle.readthedocs.org/ to read a more detailed documentation about TwitalBundle.



Integration
----------

TwitalBundle comes with all features that are already supported by [TwigBundle](https://github.com/symfony/TwigBundle) 
(forms, translations, assetic, routing, etc).  
