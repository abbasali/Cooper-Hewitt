$Id$

Single Sign-on
==============

Enables "Single sign-ons" (SSO) between related Drupal sites on one server
with a fully or partially shared database.

One site is designated as the SSO controller, all other sites are SSO clients.
Each site starts off as an independent Drupal install, running off a single
shared code base (using Drupal's multi-site feature). The databases must be
set up so that sites can access each other's tables using database table
prefixing.

See the following pages for more information:
  http://drupal.org/getting-started/6/install/multi-site
  http://drupal.org/node/2622

Requirements:
-------------

These modules require either:
- PHP5 5.1.2+
- PHP5 < 5.1.2 with Hash HMAC extension enabled
- PHP4 with PECL hash 1.1+ extension.


Setting up the controller:
--------------------------

1) Log into your controller site as an administrator.

2) Enable the SSO controller module at 'Administer > Site building > Modules'.

3) Add a line like the following to your settings.php:

   $conf['session_inc'] = 'sites/all/modules/sso/session.singlesignon.inc';

4) Go to the controller settings page at 'Administer > Settings > Single sign-on
   controller' and note down the information on that page.

Setting up a client site:
-------------------------

1) Log into your client site as an administrator.

2) Enable the SSO client module at 'Administer > Site building > Modules'.


3) Add a line like the following to your settings.php:

   $conf['session_inc'] = 'sites/all/modules/sso/session.singlesignon.inc';

4) Set up SSO table sharing for the 'authmap', 'sessions' and 'users' tables by
   adding the following to your settings.php:

   $db_prefix = array(
     'default'        => 'client prefix',
     'authmap'        => 'controller prefix',
     'sessions'       => 'controller prefix',
     'users'          => 'controller prefix',
   );
   
   Replace 'client prefix' and 'controller prefix' with the appropriate prefix
   for your set up. Take care to include trailing punctuation as needed.
   
   On MySQL, you can use 'database_name.' as a prefix to share the tables
   directly from the controller's database, and use a blank prefix for the
   client tables (which reside in the client database):

   $db_prefix = array(
     'default'        => '',
     'authmap'        => 'controller_database.',
     'sessions'       => 'controller_database.',
     'users'          => 'controller_database.',
   );

   You may want to share additional tables depending on your needs.

5) At this point, you will need to log in again to your client site as
   administrator.

6) Now visit 'Administer > Settings > Single sign-on client' and paste in the
   information from your controller site's settings page.

Upgrading:
----------

Check UPGRADE.txt for how-to on upgrading from shared sign-on 1.x.

Problems and questions:
-----------------------

Check FAQ.txt for frequently asked questions.

Authors:
  Steven Wittens <steven@acko.net> and Michael Holly <michael@strutta.com>
  for Strutta Media Inc. http://www.strutta.com/

Adopted, slightly changed and released by:
  Jakub Suchy <jakub@dynamiteheads.com> for Dynamite Heads http://www.dynamiteheads.com

Loosely based on Shared Sign-on module by:
  Daniel Convissor <danielc@analysisandsolutions.com>
  Tim Nelson <wayland@wayland.id.au>
