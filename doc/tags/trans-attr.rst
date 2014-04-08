``trans-attr``
==============

``t:trans-attr`` attribute is an alias of ``trans`` symfony tag, but works only with HTML/XML attributes, 
and allows you to translate the content of one or more attribute.

The main advantage of ``t:trans-attr`` is the preservation of original document structure, 
you do not need to change the `value` attribute with dirty code.

Let's see how it works:

.. code-block:: xml+jinja

    <inpiut value="Apple" t:trans-attr="value"/>
        

This option will allow to Symfony to extract and translate the "Apple" word.

Of course you can also use variables inside your text.

.. code-block:: xml+jinja

    <inpiut value="The pen is on the %place%" t:trans-attr="value:{'%place%':'table'}"/>


You can also translate more than one attribute on the same node.

.. code-block:: xml+jinja

    <inpiut 
        value="The pen is on the %place%" 
        title="My favorite color is %color%"
        t:trans-attr="value:{'%place%':'table'}, title:{'%color%':'red'}"/>

You can also specify different domains for your translations.

.. code-block:: xml+jinja

    <inpiut 
        value="The pen is on the %place%" 
        title="My favorite color is %color%"
        t:trans-attr="value:[{'%place%':'table'}, 'app'], title:[{'%color%':'red'}, 'colors']"/>
        
.. tip::

    See here http://symfony.com/it/doc/current/book/translation.html to learn more about Symfony translation system.