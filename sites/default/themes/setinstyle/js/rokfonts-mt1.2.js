/**
 * @version		1.5.3 August 18, 2010
 * @author		RocketTheme, LLC http://www.rockettheme.com
 * @copyright 	Copyright (C) 2007 - 2010 RocketTheme, LLC
 * @license		http://www.rockettheme.com/legal/license.php RocketTheme Proprietary Use License
 */

var RokBuildSpans=function(c,b,a){(c.length).times(function(d){var h="."+c[d];var g=function(f){f.setStyle("visibility","visible");var e=f.get("text");var k=e.split(" ");first=k[0];rest=k.slice(1).join(" ");html=f.innerHTML;if(rest.length>0){var j=f.clone().set("text"," "+rest),i=new Element("span").set("text",first);i.inject(j,"top");j.replaces(f);}};$$(h).each(function(e){b.each(function(f){e.getElements(f).each(function(i){var j=i.getFirst();if(j&&j.get("tag")=="a"){g(j);}else{g(i);}});});});});};