Add your own Twital extension
#############################


The recommended  way to add your TwitalExtension_ to ``Twital`` instance is to register it using the Symfony2
dependency injection system.

You have to add your extensions as servicees and tag them with ``twital.extension``.

Depending on your preferences you can choose witch syntax adopt.

Using XML:

.. code-block:: xml

    <service id="my.extension" class="...myExtensionClass...">
        <tag name="twital.extension" />
    </service>
    
Using YAML:

.. code-block:: yaml

    services:
        my.extension:
            class: ...myExtensionClass...
            tags:
                - { name: twital.extension }
                   

Using PHP:

.. code-block:: php
    
    <?php
    
     $container
        ->register('my.extension', '...myExtensionClass...')
        ->addTag('twital.extension')
    ;
    
    
Once you have added one of this configurations to your bundle, your extension should be available.
    
.. _`TwitalExtension`: http://twital.readthedocs.org/en/latest/api.html#extending-twital   