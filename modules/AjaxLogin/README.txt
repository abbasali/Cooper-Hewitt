Ajax Login Module
=================

Author: Todd Papaioannou (lucky@luckyspin.org)
Requires: Drupal 6
License: GPL (see LICENSE.txt)

About
-----

Ajaxlogin is a simple module that turns the login link into a modal popup that allows
a user to login via Ajax. It is heavily inspired and influenced by the Thickbox module, 
but in this case only applies the Thickbox behaviour to the user_login form. 

Installation
------------

1. Unpack this module into your modules folder (this is probably "sites/all/modules/")
2. Go to "Administer -> Site Building -> Modules" and enable the Ajax Login module
3. Go to "Adminstration by Module -> Ajax Login" and enable the ajax login functionality

Known Issues
------------

- The loadingAnimation.gif is not displayed 
- If you have the Ajax module installed too, the two modules can conflict and cause an
infinite loop in your browser. Disable the login support in the Ajax module. 

Change Log
----------

V1.0.1 - Added note about the conflict with standalone Ajax Module.
V1.0   - Initial creation of Ajax Login module 

Last Updated
------------

$Id: README.txt 317M 2009-02-07 21:52:58Z (local) $