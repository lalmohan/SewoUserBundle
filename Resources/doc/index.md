Getting Started With SewolabsUserBundle
==================================

## Prerequisites

This version of the bundle requires Symfony 2.1. 

## Installation


### Step 1: Download SewolabsUserBundle using composer

Add SewoUserBundle in your composer.json:

```js
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/lalmohan/SewoUserBundle.git"
        }
    ],

    "require": {
        "sewolabs/user-bundle":"*"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update 
```

Composer will install the bundle to your project's `sewolabs` directory.

### Step 2: Enable the bundle

Enable the bundles in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
	new Sewolabs\UserBundle\SewolabsUserBundle(),
   new FOS\UserBundle\FOSUserBundle(),
	new HWI\Bundle\OAuthBundle\HWIOAuthBundle(),

    );
}
```

### Step 3: Create your User class

The goal of this bundle is to persist some `User` class to a database (MySql,
MongoDB, CouchDB, etc). Your first job, then, is to create the `User` class
for your application. This class can look and act however you want: add any
properties or methods you find useful. This is *your* `User` class.

The bundle provides base classes which are already mapped for most fields
to make it easier to create your entity. Here is how you use it:

1. Extend the base `User` class (the class to use depends of your storage)
2. Map the `id` field. It must be protected as it is inherited from the parent class.

**Warning:**

> When you extend from the mapped superclass provided by the bundle, don't
> redefine the mapping for the other fields as it is provided by the bundle.

In the following sections, you'll see examples of how your `User` class should
look, depending on how you're storing your users (Doctrine ORM, MongoDB ODM,
or CouchDB ODM).

Your `User` class can live inside any bundle in your application. For example,
if you work at "Acme" company, then you might create a bundle called `AcmeUserBundle`
and place your `User` class in it.

**Warning:**

> If you override the __construct() method in your User class, be sure
> to call parent::__construct(), as the base User class depends on
> this to initialize some fields.

**a) Doctrine ORM User class**

If you're persisting your users via the Doctrine ORM, then your `User` class
should live in the `Entity` namespace of your bundle and look like this to
start:

``` php
<?php
// src/Acme/UserBundle/Entity/User.php

namespace Acme\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
```

**Note:**

> `User` is a reserved keyword in SQL so you cannot use it as table name.


### Step 4: Configure your application's security.yml

In order for Symfony's security component to use the FOSUserBundle, you must
tell it to do so in the `security.yml` file. The `security.yml` file is where the
basic configuration for the security for your application is contained.

Below is a minimal example of the configuration necessary to use the FOSUserBundle
in your application:

``` yaml
# app/config/security.yml
jms_security_extra:
    secure_all_services: false
    expressions: true

security:
    providers:
        fos_userbundle:
            id: fos_user.user_provider.username_email

    encoders:
        FOS\UserBundle\Model\UserInterface: sha512

    firewalls:
        secured_area:
            pattern:    ^/user/
            anonymous: true
            logout: 
                path: /user/logout
            anonymous:    true
            form_login:
                provider: fos_userbundle
                login_path: /user/login
                check_path: /user/login_check
                csrf_provider: form.csrf_provider
            oauth:
                resource_owners:
                    google:             "/user/login/check-google"
                    facebook:           "/user/login/check-facebook"
                login_path: /user/connect
                failure_path: /user/connect
                oauth_user_provider:
                    service: hwi_oauth.user.provider.fosub_bridge

    access_control:
        - { path: ^/user/login$, role: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/user/register, role: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/user/resetting, role: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/user/admin/, role: ROLE_ADMIN }

    role_hierarchy:
        ROLE_ADMIN:       ROLE_USER
        ROLE_SUPER_ADMIN: ROLE_ADMIN
```

Under the `providers` section, you are making the bundle's packaged user provider
service available via the alias `fos_userbundle`. The id of the bundle's user
provider service is `fos_user.user_provider.username`.

Next, take a look at examine the `firewalls` section. Here we have declared a
firewall named `main`. By specifying `form_login`, you have told the Symfony2
framework that any time a request is made to this firewall that leads to the
user needing to authenticate himself, the user will be redirected to a form
where he will be able to enter his credentials. It should come as no surprise
then that you have specified the user provider we declared earlier as the
provider for the firewall to use as part of the authentication process.

**Note:**

> Although we have used the form login mechanism in this example, the FOSUserBundle
> user provider is compatible with many other authentication methods as well. Please
> read the Symfony2 Security component documention for more information on the
> other types of authentication methods.

The `access_control` section is where you specify the credentials necessary for
users trying to access specific parts of your application. The bundle requires
that the login form and all the routes used to create a user and reset the password
be available to unauthenticated users but use the same firewall as
the pages you want to secure with the bundle. This is why you have specified that
the any request matching the `/login` pattern or starting with `/register` or
`/resetting` have been made available to anonymous users. You have also specified
that any request beginning with `/admin` will require a user to have the
`ROLE_ADMIN` role.

For more information on configuring the `security.yml` file please read the Symfony2
security component [documentation](http://symfony.com/doc/current/book/security.html).

**Note:**

> Pay close attention to the name, `main`, that we have given to the firewall which
> the FOSUserBundle is configured in. You will use this in the next step when you
> configure the FOSUserBundle.

### Step 5: Configure the SewolabsUserBundle

Now that you have properly configured your application's `security.yml` to work
with the FOSUserBundle, the next step is to configure the bundle to work with
the specific needs of your application.

Add the following configuration to your `config.yml` file according to which type
of datastore you are using.

``` yaml
# app/config/config.yml
fos_user:
    db_driver: orm # other valid values are 'mongodb', 'couchdb' and 'propel'
    firewall_name: main
    user_class: Sewolabs\UserBundle\Entity\User
    #...
    service:
        mailer: fos_user.mailer.twig_swift
    resetting:
        email:
            from_email:
                address:        info@sewolabs.com
                sender_name:    sewolabs
            template: SewolabsUserBundle:Resetting:resetting.email.twig
    registration:
        form:
            handler: Sewolabs_user.form.handler.registration
        confirmation:
            enabled:    true
            from_email:
                address:        info@sewolabs.com
                sender_name:    sewolabs
            template: SewolabsUserBundle:Registration:registrationconfirm.email.twig

hwi_oauth:
    resource_owners:
        facebook:
            type: facebook
            client_id: 186594204804249
            client_secret: 2793041c0d81a12bb2d37dcaea36ce03
            scope: "email"
            user_response_class: 'Sewolabs\UserBundle\OAuth\Response\FacebookUserResponse'
            paths:
                email: email
                profilepicture: picture
        google:
            type: google
            client_id: 511232487163.apps.googleusercontent.com
            client_secret: qzybAid4d8ICq1959gMkYZk1
            scope: "https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile"
            user_response_class: 'Sewolabs\UserBundle\OAuth\Response\GoogleUserResponse'
            paths:
                email: email
                profilepicture: picture

    firewall_name: secured_area
    fosub:
        username_iterations: 5
        properties:
            google: googleId
            facebook: facebookId
    connect: ~
```


### Step 6: Import SewolabsUserBundle routing files

Now that you have activated and configured the bundle, all that is left to do is
import the SewolabsUserBundle routing files.

By importing the routing files you will have ready made pages for things such as
logging in, creating users, etc.

In YAML:

``` yaml
# app/config/routing.yml
hwi_oauth_redirect:
    resource: "@HWIOAuthBundle/Resources/config/routing/redirect.xml"
    prefix:   /user/connect

SewolabsUserBundle_homepage:
    pattern:  /user/login/{service}
    defaults: { _controller: SewolabsUserBundle:Connect:redirectToService }

SewolabsUserBundle_loginpage:
    pattern:  /user/connect
    defaults: { _controller: SewolabsUserBundle:Connect:connect }

Sewolabs_oauth_connect_registration:
    pattern:  /user/registration/{key}
    defaults: { _controller: SewolabsUserBundle:Connect:registration }
    
connect:
    resource: "@HWIOAuthBundle/Resources/config/routing/connect.xml"
    prefix:   /user/connect

login:
    resource: "@HWIOAuthBundle/Resources/config/routing/login.xml"
    prefix:   /user/connect

fos_user_security:
    resource: "@FOSUserBundle/Resources/config/routing/security.xml"
    prefix: /user

fos_user_profile:
    resource: "@FOSUserBundle/Resources/config/routing/profile.xml"
    prefix: /user

fos_user_register:
    resource: "@FOSUserBundle/Resources/config/routing/registration.xml"
    prefix: /user/register

fos_user_resetting:
    resource: "@FOSUserBundle/Resources/config/routing/resetting.xml"
    prefix: /user

change_password:
    prefix:  /user
    resource: "@FOSUserBundle/Resources/config/routing/change_password.xml"

facebook_login:
    pattern: /user/login/check-facebook

google_login:
    pattern: /user/login/check-google

sewolabs_app_urlfacebook:
    pattern:  /user/connect/facebook

sewolabs_app_urlgoogle:
    pattern:  /user/connect/google
```

**Note:**

> In order to use the built-in email functionality (confirmation of the account,
> resetting of the password), you must activate and configure the SwiftmailerBundle.

### Step 7: Install Assets

For install assets run the following command.

``` bash
$  php app/console assets:install web
```


### Step 8: Update your database schema

Now that the bundle is configured, the last thing you need to do is update your
database schema because you have added a new entity, the `User` class which you
created in Step 4.

For ORM run the following command.

``` bash
$ php app/console doctrine:schema:update --force
```










