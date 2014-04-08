TwitalBundle (Twital with Symfony2)
===================================

TwitalBundle is a  [Symfony2](http://symfony.com) bundle that integrates [Twital](https://github.com/goetas/twital) template engine into Synfony2.
This enables you to use all Twig/Symfony2 functionalities with Twital template engine language syntax.

To learn more about *Twital*, you can read the  [dedicated documentation](http://twital.readthedocs.org).


Documentation
-------------

Go here http://twitalbundle.readthedocs.org/ to read a more detailed documentation about **TwitalBundle**.

Install
-------

The recommended way to install ``TwitalBundle`` is via [Composer](https://getcomposer.org/).

Using  ``composer require`` command

```bash
composer require 'goetas/twital-bundle:*'
```
Or adding its dependency to your ``composer.json`` file

```js
"require": {
    ..
    "goetas/twital-bundle": "*",
    ..
}
```


Enable the bundle
---------------

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
--------

In order to make it work you have to enable ``twital`` template engine inside your ``config.yml``.

```yaml
framework:
    templating:
        engines: ['twig', 'twital']
        
#optional configurations for file extension matching 
goetas_twital:
    source_adapter:
        twital.source_adapter.xml: ['/\.xml\.twital$/', '/\.atom\.twital$/']
        twital.source_adapter.html: ['/\.html\.twital$/', '/\.htm\.twital$/']
        twital.source_adapter.xhtml: ['/\.xhtml\.twital$/']
```

Integration
----------

``TwitalBundle`` comes with all features that are already supported by [TwigBundle](https://github.com/symfony/TwigBundle) 
(forms, translations, assetic, routing, etc).  


Note
----

I'm sorry for the *terrible* english fluency used inside the documentation, I'm trying to improve it. 
Pull Requests are welcome.
