[![Build Status](https://travis-ci.org/goetas/twital-bundle.svg?branch=master)](https://travis-ci.org/goetas/twital-bundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/goetas/twital-bundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/goetas/twital-bundle/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/goetas/twital-bundle/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/goetas/twital-bundle/?branch=master)

TwitalBundle (Twital with Symfony2)
===================================


TwitalBundle is a [Symfony2](http://symfony.com/) bundle that integrates the [Twital](https://github.com/goetas/twital/) template engine into Synfony2 framework.
This enables you to use all Twig/Symfony2 functionalities with the Twital template engine language syntax.

To learn more about Twital, you can read the [dedicated documentation](http://twital.readthedocs.org/).



Install
-------

There are two recommended ways to install TwitalBundle via [Composer](https://getcomposer.org/):

* using the ``composer require`` command:

```bash
composer require 'goetas/twital-bundle:*'
```
* adding the dependency to your ``composer.json`` file:

```js
"require": {
    ..
    "goetas/twital-bundle": "*",
    ..
}
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


Note
----

I'm sorry for the *terrible* english fluency used inside the documentation, I'm trying to improve it. 
Pull Requests are welcome.
