``trans-attr-n``
==============

``t:trans-attr-n`` attribute is an alias of ``transchoice`` symfony tag, but works only with HTML/XML attributes, 
and allows you to translate the content of one or more attribute using also plural forms.


Let's see how it works:

.. code-block:: xml+jinja

    <inpiut 
        value="{0} There are no apples|{1} There is one apple|]1,Inf] There are %count% apples" 
        t:trans-attr-n="value:[3, {'%count%':3}]" />
        

This option will allow to Symfony to extract and translate the "one apple" and "%count% apples" sentences.

Of course you can also use variables inside your text.

.. code-block:: xml+jinja

    <inpiut 
        value="{0} %name% don't like apples|{1} %name% is eating one apple|]1,Inf] %name% is eating %count% apples" 
        t:trans-attr-n="value:[3, {'%count%':3, '%name%':'John'}]" />
        


You can also translate more than one attribute on the same node.

.. code-block:: xml+jinja

    <inpiut 
        value="{0} %name% don't like apples|{1} %name% is eating one apple|]1,Inf] %name% is eating %count% apples" 
        title="{0} There are no apples|{1} There is one apple|]1,Inf] There are %count% apples"
        t:trans-attr-n="value:[3, {'%count%':3, '%name%':'John'}], title:[3, {'%count%':3}]" />
        
You can also specify different domains for your translations.

.. code-block:: xml+jinja

    <inpiut 
        value="{0} %name% don't like apples|{1} %name% is eating one apple|]1,Inf] %name% is eating %count% apples" 
        t:trans-attr-n="value:[3, {'%count%':3, '%name%':'John'}, 'app']" />


You can also combine plural and non-plural translations

.. code-block:: xml+jinja

    <inpiut 
        value="{0} %name% don't like apples|{1} %name% is eating one apple|]1,Inf] %name% is eating %count% apples"
        title="The pen is on the %place%"
        
        t:trans-attr="title:{'%place%':'table'}" 
        t:trans-attr-n="value:[3, {'%count%':3, '%name%':'John'}]" />


.. tip::

    See here http://symfony.com/it/doc/current/book/translation.html to learn more about Symfony translation system.