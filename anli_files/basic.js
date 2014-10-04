$(function(){
//nav主菜单
function navSlider(){
    var $nav = $(".lvs_nav"),
	$cur = $(".lvs_nav li.cur a"),
	$anchor = $("a",$nav.children()),
	curIdx = $("li.cur",$nav).index();
	$anchor.each(function(index){
		$(this).mouseenter(function(){
			$(this).parent().addClass("cur").siblings().removeClass("cur");
		});
	});
	$nav.mouseleave(function(){
		$anchor.parent(":eq("+curIdx+")").addClass("cur").siblings().removeClass("cur");
	});
};
navSlider();


//topdan榜单
$(".topdan dl").mouseover(function () { var obj = $(this); obj.addClass("active"); obj.siblings("dl").each(function () { $(this).removeClass("active"); }) });

//七周年庆典
$(".lvtopadv_close").click(function () {
    $(".lvtopadv").remove();
    $('#Z_TypeList').LvshouSider({
        fTop: 180
    });
});

//鼠标滑入某li中的某div里，调整其同辈div元素的透明度，由于li的背景为黑色，所以会有变暗的效果
$(".flight").hover(function(){
	$(this).siblings().children(".bglight").css({"opacity":0.4,"background":"#000"});
},function() {
	$(".flight").children(".bglight").css("opacity",0.001);
});	


//modpl评论
$.fn.rollGallery=function( options ){
	
	var opts=$.extend({},$.fn.rollGallery.defaults,options);
	
	return this.each(function(){
		var _this=$(this);
		var step=0;
		var maxMove=0;
		var animateArgu=new Object();
		_this.intervalRGallery=null;
		
		if( opts.noStep&&(!options.speed) ) opts.speed=30;
		
		if( opts.direction=="left"){
			step=_this.children( opts.childrenSel ).outerWidth(true);
		}else{
			step=_this.children( opts.childrenSel ).outerHeight(true);
		}
		
		maxMove=-(step*_this.children( opts.childrenSel ).length);
		_this[0].maxMove=maxMove;
		if( opts.rollNum ) step*=opts.rollNum;	
		animateArgu[ opts.direction ]="-="+step;	
				
		_this.children( opts.childrenSel ).slice( 0,opts.showNum ).clone(true).appendTo( _this );
		_this.mouseover( function(){ clearInterval( _this.intervalRGallery ); });
		_this.mouseout( function(){ _this.intervalRGallery=setInterval( function(){
				if( parseInt(_this.css( opts.direction ))<=maxMove ){
					_this.css( opts.direction , "0px");
				}
				if( opts.noStep ){
					_this.css( opts.direction, (parseInt(_this.css( opts.direction ))-opts.speedPx+"px") );
				}
				else{
					_this.animate( animateArgu ,opts.aniSpeed,opts.aniMethod );
				}
			}, opts.speed );});
		
		_this.mouseout();
	});
			
};

$.fn.rollGallery.defaults={
	direction : "left",
	speed : 3000,
	noStep : false,
	speedPx : 1,
	showNum : 1,
	aniSpeed:"slow",
	aniMethod:"swing",
	childrenSel:"*"
};
});

/* 加入收藏夹代码 */
function addFavorite2() {
    var url = window.location;
    var title = document.title;
    var ua = navigator.userAgent.toLowerCase();
    if (ua.indexOf("360se") > -1) {
        alert("由于360浏览器功能限制，请按 Ctrl+D 手动收藏！");
    }
    else if (ua.indexOf("msie 8") > -1) {
        window.external.AddToFavoritesBar(url, title); //IE8
    }
    else if (document.all) {
        try {
            window.external.addFavorite(url, title);
        } catch (e) {
            alert('您的浏览器不支持,请按 Ctrl+D 手动收藏!');
        }
    }
    else if (window.sidebar) {
        window.sidebar.addPanel(title, url, "");
    }
    else {
        alert('您的浏览器不支持,请按 Ctrl+D 手动收藏!');
    }
}


$(document).ready(function() {
	/*jqueryscrollto*/
(function (d)
{
    var k = d.scrollTo = function (a, i, e)
        {
            d(window).scrollTo(a, i, e)
        };
    k.defaults = {
        axis: 'xy',
        duration: parseFloat(d.fn.jquery) >= 1.3 ? 0 : 1
    };
    k.window = function (a)
    {
        return d(window)._scrollable()
    };
    d.fn._scrollable = function ()
    {
        return this.map(function ()
        {
            var a = this,
                i = !a.nodeName || d.inArray(a.nodeName.toLowerCase(), ['iframe', '#document', 'html', 'body']) != -1;
            if (!i) return a;
            var e = (a.contentWindow || a).document || a.ownerDocument || a;
            return d.browser.safari || e.compatMode == 'BackCompat' ? e.body : e.documentElement
        })
    };
    d.fn.scrollTo = function (n, j, b)
    {
        if (typeof j == 'object')
        {
            b = j;
            j = 0
        }
        if (typeof b == 'function') b = {
            onAfter: b
        };
        if (n == 'max') n = 9e9;
        b = d.extend(
        {}, k.defaults, b);
        j = j || b.speed || b.duration;
        b.queue = b.queue && b.axis.length > 1;
        if (b.queue) j /= 2;
        b.offset = p(b.offset);
        b.over = p(b.over);
        return this._scrollable().each(function ()
        {
            var q = this,
                r = d(q),
                f = n,
                s, g = {},
                u = r.is('html,body');
            switch (typeof f)
            {
            case 'number':
            case 'string':
                if (/^([+-]=)?\d+(\.\d+)?(px|%)?$/.test(f))
                {
                    f = p(f);
                    break
                }
                f = d(f, this);
            case 'object':
                if (f.is || f.style) s = (f = d(f)).offset()
            }
            d.each(b.axis.split(''), function (a, i)
            {
                var e = i == 'x' ? 'Left' : 'Top',
                    h = e.toLowerCase(),
                    c = 'scroll' + e,
                    l = q[c],
                    m = k.max(q, i);
                if (s)
                {
                    g[c] = s[h] + (u ? 0 : l - r.offset()[h]);
                    if (b.margin)
                    {
                        g[c] -= parseInt(f.css('margin' + e)) || 0;
                        g[c] -= parseInt(f.css('border' + e + 'Width')) || 0
                    }
                    g[c] += b.offset[h] || 0;
                    if (b.over[h]) g[c] += f[i == 'x' ? 'width' : 'height']() * b.over[h]
                }
                else
                {
                    var o = f[h];
                    g[c] = o.slice && o.slice(-1) == '%' ? parseFloat(o) / 100 * m : o
                }
                if (/^\d+$/.test(g[c])) g[c] = g[c] <= 0 ? 0 : Math.min(g[c], m);
                if (!a && b.queue)
                {
                    if (l != g[c]) t(b.onAfterFirst);
                    delete g[c]
                }
            });
            t(b.onAfter);

            function t(a)
            {
                r.animate(g, j, b.easing, a &&
                function ()
                {
                    a.call(this, n, b)
                })
            }
        }).end()
    };
    k.max = function (a, i)
    {
        var e = i == 'x' ? 'Width' : 'Height',
            h = 'scroll' + e;
        if (!d(a).is('html,body')) return a[h] - d(a)[e.toLowerCase()]();
        var c = 'client' + e,
            l = a.ownerDocument.documentElement,
            m = a.ownerDocument.body;
        return Math.max(l[h], m[h]) - Math.min(l[c], m[c])
    };

    function p(a)
    {
        return typeof a == 'object' ? a : {
            top: a,
            left: a
        }
    }
})(jQuery);

$('.allscroll a,.rscroll').click(function (e) {	  		
	$.scrollTo( this.hash || 0, 500, {offset:0} );
	
  });
  
});