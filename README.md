SewolabsUserBundle
=============

The SewoUserBundle adds support for a database-backed user system and 
authenticating users via oauth in Symfony2.
It provides a flexible framework for user management that aims to handle
common tasks such as user registration and password retrieval.

Features include:

- Users can be stored via Doctrine ORM, MongoDB/CouchDB ODM or Propel
- Registration support, with an optional confirmation per mail
- Password reset support
- Alternate login using Auth(facebook,google)

**Caution:** This bundle is developed in sync with [symfony's repository](https://github.com/symfony/symfony).

Documentation
-------------

The bulk of the documentation is stored in the `Resources/doc/index.md`
file in this bundle:

[Read the Documentation for master](https://github.com/lalmohan/SewoUserBundle/blob/master/Resources/doc/index.md)

Installation
------------

All the installation instructions are located in [documentation](https://github.com/lalmohan/SewoUserBundle/blob/master/Resources/doc/index.md).

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

    Resources/meta/LICENSE

About
-----

See also the list of [contributors](https://github.com/lalmohan/SewoUserBundle/graphs/contributors).

Reporting an issue or a feature request
---------------------------------------

Issues and feature requests are tracked in the [Github issue tracker](https://github.com/lalmohan/SewoUserBundle/issues).

When reporting a bug, it may be a good idea to reproduce it in a basic project
built using the [Symfony Standard Edition](https://github.com/symfony/symfony-standard)
to allow developers of the bundle to reproduce the issue by simply cloning it
and following some steps.
