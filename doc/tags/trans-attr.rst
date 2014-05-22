``trans-attr``
==============

The ``t:trans-attr`` attribute is an alias of the ``trans`` Symfony tag, but it works only with HTML/XML attributes, 
and allows you to translate the content of one or more attributes.

The main advantage of ``t:trans-attr`` is the preservation of the original document structure: 
you do not need to change the `value` attribute with dirty code.

Let's see how does it work:

.. code-block:: xml+jinja

    <inpiut value="Apple" t:trans-attr="value"/>
        

This option will allow Symfony to extract and translate the "Apple" word.

Of course, you can also use variables inside your text.

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

    See here http://symfony.com/it/doc/current/book/translation.html to learn more about the Symfony translation system.
