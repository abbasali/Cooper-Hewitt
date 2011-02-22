/**
 * @version		1.5.3 August 18, 2010
 * @author		RocketTheme, LLC http://www.rockettheme.com
 * @copyright 	Copyright (C) 2007 - 2010 RocketTheme, LLC
 * @license		http://www.rockettheme.com/legal/license.php RocketTheme Proprietary Use License
 */

window.addEvent('domready', function() {
	new SmoothScroll();
});

eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('n.k(\'w\',3(){f 1C()});h o=15,4;n.k(\'w\',3(){h b=5.g(\'1u-1t\');2(b){o=f P.1r(n);b.7(\'1p\',\'M\').k(\'t\',3(e){f J(e).I();o.Q()})};2(s.u.X){h c=5.g(\'1e-1d\').1c(\'.Z\');2(c.F){c.12(3(a,i){2(a.1n(\'16\'))a.x(\'Z-16\')})}}4=f 14(n.18);h d=$$(\'.1a 1b\');2(d.F){2(s.u.1f)d.7(\'-1g-W-V\',\'U\');2(s.u.T)d.7(\'-T-W-V\',\'U\')}});h 14=f 1h({1i:[1j,1k],6:{\'p\':\'\',\'L\':15,\'K\':1o,\'q\':0.9,\'1s\':G,\'Y\':G,\'11\':G},1v:3(a){1.1x(a);2(!1.6.p.F)j;1.p=$$(1.6.p);1.4=5.g(\'13-4\');1.r=5.g(\'13-4-8\');1.l=\'8\';2(!1.4)j;2(!1.6.11&&1.r)1.r.7(\'1F\',\'M\');2(1.6.L)1.4.7(\'1z\',\'v\');1.y(1.4);1.z=f P.1y(1.4,{1w:\'1q\',17:1l}).19(\'q\',0);1.A(1.p)},y:3(a){2(!1.6.L)j;h b=1.6.K;j a.7(\'K\',b)},A:3(b){2(1.r){1.r.k(\'t\',3(e){f J(e).I();1.8()}.S(1))};2(1.6.Y){1.4.k(\'t\',1.8.S(1))}b.12(3(a){a.k(\'t\',1.R.1m(1))},1)},R:3(e){f J(e).I();1[(1.l==\'m\')?\'8\':\'m\']()},m:3(){2(1.l=="m")j;1.y(1.4);2(o)o.Q();1.z.N(\'q\',1.6.q);1.l=\'m\';1.O(\'m\')},8:3(){2(1.l==\'8\')j;1.z.N(\'q\',0);1.l=\'8\';1.O(\'8\')}});2(s.u.X){n.A({\'w\':3(){5.g(5.H).x(\'E-D-C\').7(\'B\',\'v\')},\'1A\':3(){(3(){5.g(5.H).1B(\'E-D-C\').7(\'B\',\'1D\')}).1E(10)},\'1G\':3(){5.g(5.H).x(\'E-D-C\').7(\'B\',\'v\')}})}',62,105,'|this|if|function|panel|document|options|setStyle|close|||||||new|id|var||return|addEvent|status|open|window|rokscroll|hooks|opacity|panelClose|Browser|click|Engine|hidden|domready|addClass|setHeight|fx|addEvents|visibility|wait|please|ie|length|true|body|stop|Event|height|fixedHeight|none|start|fireEvent|Fx|toTop|toggle|bind|webkit|12px|radius|border|trident4|closeByClick|separator||showCloseButton|each|showcase|showcasePanel|false|daddy|duration|showcasePanelOptions|set|styleslist|div|getElements|menu|horiz|gecko|moz|Class|Implements|Options|Events|300|bindWithEvent|hasClass|337|outline|cancel|Scroll|scrollToTop|scroll|top|initialize|link|setOptions|Tween|overflow|load|removeClass|SmoothScroll|visible|delay|display|unload'.split('|'),0,{}));


// IE6 bad looking hack :)
if (Browser.Engine.trident4) {
	window.addEvents({
		'domready': function() {
			document.id(document.body).addClass('ie-please-wait').setStyle('visibility', 'hidden');
		},
	
		'load': function() {
			(function() {document.id(document.body).removeClass('ie-please-wait').setStyle('visibility', 'visible');}).delay(10);
			var arrow = $$('.feature-arrow-r')[0], li = $$('ul.menutop').getFirst()[0];
			if (arrow) arrow.fireEvent('mouseleave', false, 500);
			if (li) li.addEvents({
				'mouseenter': function() {
					li.setStyle('padding-right', 1);
				},
				'mouseleave': function() {
					li.setStyle('padding-right', 0);
				}
			});
			
		},
		
		'unload': function() {
			document.id(document.body).addClass('ie-please-wait').setStyle('visibility', 'hidden');
		}
	});
}

// IE7 RokStories Hack
if (Browser.Engine.trident) {
	window.addEvent('domready', function() {
		
		var rokstories = $$('.rokstories-layout2 .desc-container'), list = [];
		rokstories.each(function(rokstory, i) {
			if (!rokstory.getElements('.description span').length) list.push(i);
		});
		if (list.length) list.each(function(value) {
			rokstories[value].setStyle('display', 'none');
		});

	});
}