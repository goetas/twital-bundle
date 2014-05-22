``trans-n``
===========

The ``t:trans-n`` attribute is an alias of the ``transchoice`` Symfony tag
and allows you to translate the content of a node with plurals.

Let's see how does it work:

.. code-block:: xml+jinja

    <div t:trans-n="applesCount">
        {0} There are no apples|{1} There is one apple|]1,Inf] There are %count% apples
    </div>


Of course, you can also use variables in your text.

.. code-block:: xml+jinja

    <div t:trans-n="applesCount, {'%name%':'John'}">
        {0} %name% don't like apples|{1} %name% is eating one apple|]1,Inf] %name% is eating %count% apples
    </div>

You can also specify different domains for your translations.

.. code-block:: xml+jinja

    <div t:trans-n="applesCount, {'%name%':'John'}, 'app'">
        {0} %name% don't like apples|{1} %name% is eating one apple|]1,Inf] %name% is eating %count% apples
    </div>


.. tip::

    See here http://symfony.com/it/doc/current/book/translation.html to learn more about the Symfony translation system.
