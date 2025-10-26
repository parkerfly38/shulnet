ShulNET Synagogue Membership Software
==============================

ShulNET is open source membership software written in PHP that combines event planning, CRM, a CMS, invoicing, subscription management, marketing tools (like e-mail campaigns), a shopping cart, and secure content delivery, forked from v115 of Castlamp's Zenbership.

Author: Cove Brook Coders (https://www.covebrookcode.com/)  
Online: [https://www.covebrookcode.com/shulnet](https://www.covebrookcode.com/shulnet)

Version Dependencies
====================

- PHP 8.4.4
- Mysql 8.0 or higher

Getting Started
===============

You can either copy the contents of this repo, using the root of this application as the root of your PHP application, served in either Apache, NGINX, or appropriately configured IIS.  You will need libfree, libpng, libssl, unzip, and calendar dependencies enabled and installed, as well as some others.

You should also be able to run composer installations on the server, or have support do it, as this has SDK dependencies we do not obviously check in to the repository.

There are also two docker composer files and two dockerfile files in this repo that you can use to stand up an environment.  The files annotated as debug will add XDEBUG integrations so you can do stepped debugging in your project.  It contains everything you need for MySQL, storage volumes, although the docker debug application version will use your local file context so you can make adjustments in real time.

In either case, you will need to take our example .env file and replace its contents with your own unique values when you use either docker compose.

Once your environment is setup, navigate to your root url plus "/setup", and the guided setup will commence.

Issue Tracking
==============
Please log issues in the github repo.  The "team", such that it is, will attempt to evaluate and triage.

Contribution Policy
===================
Please feel free to work out feature or bug branches against "development" as trunk.  We'll review any pull requests against it.

License
=======

ShulNET is licensed under the [GPLv3](https://www.covebrookcode.com/members/license.html).


Resources
=========

- [Docker Images](https://hub.docker.com/repository/docker/parkerfly38/shulnet)
- [Server Requirements](https://documentation.covebrookcode.com/docs/shulnet/server-requirements/)
- [Installation and Setup](https://documentation.covebrookcode.com/docs/shulnet/installation-and-setup/)
- [Post-Installation Getting Started Guide](https://documentation.covebrookcode.com/docs/shulnet/post-installation-recommended-steps/)


Credits
=======

Shulnet is developed and maintained by Brian Kresge / Cove Brook Coders, based off of Zenbership by Jon Belelieu.

This fork is being actively maintained and developed by Brian Kresge ([@parkerfly](http://twitter.com/parkerfly)).
