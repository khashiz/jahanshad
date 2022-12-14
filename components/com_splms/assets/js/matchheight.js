/**
* jquery.matchHeight-min.js v0.5.2
* http://brm.io/jquery-match-height/
* License: MIT
*/
(function(b){var f=-1,e=-1,m=function(a){var d=null,c=[];b(a).each(function(){var a=b(this),h=a.offset().top-g(a.css("margin-top")),k=0<c.length?c[c.length-1]:null;null===k?c.push(a):1>=Math.floor(Math.abs(d-h))?c[c.length-1]=k.add(a):c.push(a);d=h});return c},g=function(b){return parseFloat(b)||0};b.fn.matchHeight=function(a){if("remove"===a){var d=this;this.css("height","");b.each(b.fn.matchHeight._groups,function(b,a){a.elements=a.elements.not(d)});return this}if(1>=this.length)return this;a="undefined"!==
typeof a?a:!0;b.fn.matchHeight._groups.push({elements:this,byRow:a});b.fn.matchHeight._apply(this,a);return this};b.fn.matchHeight._groups=[];b.fn.matchHeight._throttle=80;b.fn.matchHeight._maintainScroll=!1;b.fn.matchHeight._apply=function(a,d){var c=b(a),e=[c],h=b(window).scrollTop(),k=b("html").outerHeight(!0),f=c.parents().filter(":hidden");f.css("display","block");d&&(c.each(function(){var a=b(this),c="inline-block"===a.css("display")?"inline-block":"block";a.data("style-cache",a.attr("style"));
a.css({display:c,"padding-top":"0","padding-bottom":"0","border-top-width":"0","border-bottom-width":"0",height:"100px"})}),e=m(c),c.each(function(){var a=b(this);a.attr("style",a.data("style-cache")||"").css("height","")}));b.each(e,function(a,c){var e=b(c),f=0;d&&1>=e.length||(e.each(function(){var a=b(this),c="inline-block"===a.css("display")?"inline-block":"block";a.css({display:c,height:""});a.outerHeight(!1)>f&&(f=a.outerHeight(!1));a.css("display","")}),e.each(function(){var a=b(this),c=0;
"border-box"!==a.css("box-sizing")&&(c+=g(a.css("border-top-width"))+g(a.css("border-bottom-width")),c+=g(a.css("padding-top"))+g(a.css("padding-bottom")));a.css("height",f-c)}))});f.css("display","");b.fn.matchHeight._maintainScroll&&b(window).scrollTop(h/k*b("html").outerHeight(!0));return this};b.fn.matchHeight._applyDataApi=function(){var a={};b("[data-match-height], [data-mh]").each(function(){var d=b(this),c=d.attr("data-match-height")||d.attr("data-mh");a[c]=c in a?a[c].add(d):d});b.each(a,
function(){this.matchHeight(!0)})};var l=function(){b.each(b.fn.matchHeight._groups,function(){b.fn.matchHeight._apply(this.elements,this.byRow)})};b.fn.matchHeight._update=function(a,d){if(d&&"resize"===d.type){var c=b(window).width();if(c===f)return;f=c}a?-1===e&&(e=setTimeout(function(){l();e=-1},b.fn.matchHeight._throttle)):l()};b(b.fn.matchHeight._applyDataApi);b(window).bind("load",function(a){b.fn.matchHeight._update()});b(window).bind("resize orientationchange",function(a){b.fn.matchHeight._update(!0,
a)})})(jQuery);


//Match Height
jQuery(function($) {
	$(window).on('load', function(){
		$('.splms-match-height').matchHeight();
	});
});
