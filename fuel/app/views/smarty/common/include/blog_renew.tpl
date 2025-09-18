<!--{%if ($arrBlog['arrPosts']|count) > 0%}-->
<!--{%assign var=mallurl value=""%}-->
<!--{%if isset($shop_url) && $shop_url != ""%}-->
	<!--{%assign var=mallurl value="/mall/`$shop_url`"%}-->
<!--{%/if%}-->
<script>
$(function(){
//	$('.pin-on').click(function(){
//		pin($(this).attr('data'));
//	});
//	$('.pin-off').click(function(){
//		pin($(this).attr('data'));
//	});

});

function pin(id)
{
    var formData = new FormData();
    formData.append('id', id);
    formData.append('pin', 'brpin_@iaruhgistg90uy5i');
    var url = '/api/pin';

    $.ajax({
        url  : url,
        username:"demo",
        password:"testtest",
        type : "POST",
        data : formData,
        cache       : false,
        contentType : false,
        processData : false,
	    async: false,
        dataType    : "json"
    })
    .done(function(data){
    	if (data.pin == 'on')
    	{
	    	$('#pin_'+id).attr('class', 'pin-on');
	    	$('#pin_'+id+' img').attr('src', '/common/images/blog/pin-on.png');
//	    	alert('ピン留めされました。');
//	    	location.hash="blog";
    	}
    	else
    	{
	    	$('#pin_'+id).attr('class', 'pin-off');
	    	$('#pin_'+id+' img').attr('src', '/common/images/blog/pin-off.png');
//	    	location.hash="blog";
    	}
    })
    .fail(function(jqXHR, textStatus, errorThrown){
        alert("fail");
    });
}

</script>

<style>
.pin-on
{
	position:absolute;
	left:89%;
	top:4px;
	z-index:1;
}
.pin-on
{
	width:25px!important;
	max-width: inherit;
}
@media screen and (max-width: 767px) {
	.pin-on
	{
		top:3px;
		width:16px!important;
		max-width: inherit;
	}
}
</style>

<section class="sec_slide snap blog" id="blog">
	<div class="wrap_contents">
		<div class="head_01 clearfix">
			<h2 class="times">BLOG</h2>
			<a href="<!--{%$mallurl%}-->/blog/" class="times fr btn_viewall"><i class="icon-list"></i> VIEW ALL</a>
		</div>
		<div class="slide_snap owl-carousel <!--{%if count($arrBlog['arrPosts']) <= $smarty.const.CAROUSEL_NO_LOOP %}--> noloop <!--{%/if%}-->">
			<!--{%foreach $arrBlog['arrPosts'] as $post%}-->
<div>
				<!--{%if $post['pin'] == 'on'%}-->
					<img src="/common/images/blog/pin-on.png" class="pin-on" />
				<!--{%else%}-->
				<!--{%/if%}-->

				<!--{%if $post['flg_shop']%}-->
				<a class="block" href="<!--{%$mallurl%}-->/blog/?entry=<!--{%$post['ID']%}-->">
				<!--{%else%}-->
				<a class="block" href="/blog/?entry=<!--{%$post['ID']%}-->">
				<!--{%/if%}-->
					<img loading="lazy" src="<!--{%$post['thumb_url']%}-->"/>
					<div class="tit_snap"><!--{%$post['post_title']|replace:'[BR]':'<br/>'%}--><span><!--{%$post['post_date']|date_format:"%Y.%m.%d"%}-->　｜　<!--{%$post['last_name']%}--><!--{%$post['first_name']%}--></span></div>
				</a>
</div>
			<!--{%/foreach%}-->
		</div>
		<a href="<!--{%$mallurl%}-->/blog/" class="times btn_viewmore_sp sp_portrait_only">VIEW MORE </a>
	</div>
</section>
<!--{%/if%}-->
