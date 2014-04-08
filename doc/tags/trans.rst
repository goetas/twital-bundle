``trans``
========

``t:trans`` attribute is an alias of ``trans`` symfony tag
and allows you to translate the content of a node.

Let's see how it works:

.. code-block:: xml+jinja

    <div t:trans="">
        Hello world
    </div>


This option will allow to Symfony to extract and translate the "Hello world" sentence.

Of course you can also use variables inside your text.

.. code-block:: xml+jinja

    <div t:trans="{'%name%':'John'}">
        Hello %name%
    </div>

You can also specify different domains for your translations.

.. code-block:: xml+jinja

    <div t:trans="{'%name%':'John'}, 'app'">
        Hello %name%
    </div>



.. tip::

    See here http://symfony.com/it/doc/current/book/translation.html to learn more about Symfony translation system.