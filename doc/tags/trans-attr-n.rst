``trans-attr-n``
================

The ``t:trans-attr-n`` attribute is an alias of the ``transchoice`` Symfony tag, but it works only with HTML/XML attributes, 
and allows you to translate the content of one or more attribute using also plural forms.


Let's see how does it work:

.. code-block:: xml+jinja

    <inpiut 
        value="There is one apple|There are %count% apples" 
        t:trans-attr-n="value:[3, {'%count%':3}]" />
        

This option will allow Symfony to extract and translate the 
"There is one apple", "There are %count% apples", and "%count% apples" sentences.

Of course, you can also use variables in your text.

.. code-block:: xml+jinja

    <inpiut 
        value="%name% is eating one apple|%name% is eating %count% apples" 
        t:trans-attr-n="value:[3, {'%count%':3, '%name%':'John'}]" />
        


You can also translate more than one attribute on the same node.

.. code-block:: xml+jinja

    <inpiut 
        value="%name% is eating one apple|%name% is eating %count% apples" 
        title="There is one apple|There are %count% apples"
        t:trans-attr-n="value:[3, {'%count%':3, '%name%':'John'}], title:[3, {'%count%':3}]" />
        
You can also specify different domains for your translations.

.. code-block:: xml+jinja

    <inpiut 
        value="%name% is eating one apple|%name% is eating %count% apples" 
        t:trans-attr-n="value:[3, {'%count%':3, '%name%':'John'}, 'app']" />


You can also combine plural and non-plural translations

.. code-block:: xml+jinja

    <inpiut 
        value="%name% is eating one apple|%name% is eating %count% apples"
        title="The pen is on the %place%"
        
        t:trans-attr="title:{'%place%':'table'}" 
        t:trans-attr-n="value:[3, {'%count%':3, '%name%':'John'}]" />


.. tip::

    See here http://symfony.com/it/doc/current/book/translation.html to learn more about the Symfony translation system.
