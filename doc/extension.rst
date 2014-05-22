Add your own Twital extension
#############################


The recommended way to add your TwitalExtension_ to ``Twital`` instance is registering it using the 
`Symfony2 dependency injection <http://symfony.com/doc/current/components/dependency_injection/index.html>`__ system.

You have to add your extensions as services and tag them with the ``twital.extension`` tag.

Depending on your preferences, you can choose which syntax to adopt.

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
