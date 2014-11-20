/**
 * Dynamiczne odliczanie czasu do podanej daty.
 *
 * @example
 * $("body").kkCountDown();
 *
 * @type jQuery
 *
 * @name $.fn.kkCountDown
 * @author Krzysztof Furtak
 * @version 1.2
 */
(function(i){i.fn.kkCountDown=function(b){function f(c){s="";if(c<10)c="0"+c;return c}function k(){for(var c=i(".kkcount-down"),d=0;d<c.length;d++){var e=new Date;e=Math.floor(e.getTime()/1E3);var a=c.eq(d).attr("time")-e;if(a<=0)if(b.callback===false)c.eq(d).html(b.afterCount);else if(typeof b.callback=="function"){b.callback.call();c.eq(d).removeClass("kkcount-down");c.eq(d).html(" ")}else c.eq(d).html(b.afterCount);else if(a<=86400){e=f(a%60);a=Math.floor(a/60);var g=f(a%60);a=Math.floor(a/60);
var h=f(a%24);a=a=Math.floor(a/24);var j=a==1?b.dayText:b.daysText;b.displayDays?c.eq(d).html('<span style="color:'+b.colorTextDay+';">'+a+" "+j+" "+h+":"+g+":"+e+"</span>"):c.eq(d).html('<span style="color:'+b.colorTextDay+';">'+h+":"+g+":"+e+"</span>")}else{e=f(a%60);a=Math.floor(a/60);g=f(a%60);a=Math.floor(a/60);h=f(a%24);a=a=Math.floor(a/24);j=a==1?b.dayText:b.daysText;b.displayDays?c.eq(d).html('<span style="color:'+b.colorText+';">'+a+" "+j+" "+h+":"+g+":"+e+"</span>"):c.eq(d).html('<span style="color:'+
b.colorText+';">'+h+":"+g+":"+e+"</span>")}b.addClass&&c.eq(d).addClass(b.addClass)}setTimeout(function(){k()},1E3)}b=i.extend({dayText:"day",daysText:"days",colorText:"#000000",colorTextDay:"#cf0000",afterCount:"---",displayDays:true,addClass:false,callback:false},b);k()}})(jQuery);