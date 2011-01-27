// $Id: ajaxlogin.js 316 2009-02-07 21:47:11Z lucky $

// Add the thickbox class to the login links - borrowed from the Thickbox module 
Drupal.behaviors.initAjaxLogin = function(context) {
 
	// Re-write our sign in links
    $("a[@href*='/user/login']").addClass('thickbox').each(function() { this.href = this.href.replace(/user\/login(%3F|\?)?/,"user/login/ajaxlogin?height=230&width=415&") });
    $("a[@href*='?q=user/login']").addClass('thickbox').each(function() { this.href = this.href.replace(/user\/login/,"user/login/ajaxlogin&height=230&width=415") });
}