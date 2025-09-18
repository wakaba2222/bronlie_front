<div class="wrap_contents bread">
	<ul>
		<li><a href="/">TOP</a></li>
		<li class="arrow">＞</li>
		<li><a href="/mall/">MALL</a></li>
		<li class="arrow">＞</li>
		<li><a href="/mall/<!--{%$shop_url%}-->/"><!--{%$shop_name%}--></a></li>
		<li class="arrow">＞</li>
		<li><a href="/mall/<!--{%$shop_url%}-->/blog/">BLOG</a></li>
		<li class="arrow">＞</li>
		<li><!--{%$post['post_title']%}--></li>
	</ul>
</div>
<section class="tit_page">
	<h2 class="times">SHOP BLOG</h2>
</section>
<style>
.plist
{
	width:50%;
	text-align:center;
	margin-bottom:20px;
}
.plist a
{
	text-decoration:none!important;
}
.plist p
{
/*	margin:5px!important;*/
}
.box2
{
	display:flex;
}
.shop
{
	letter-spacing: 0px;
    font-size: 14px;
    color: #a1a2b1;
}
.price
{
	font-weight: 600;
    letter-spacing: 0px;
    font-size: 16px;
    margin-bottom: 0px!important;
}
.brand
{
	letter-spacing: 0px;
    margin-top: 15px;
    margin-bottom: 0px!important;
    font-weight: 600;
    text-transform: uppercase;
    font-size:75%;
}
</style>
<section class="sec_2col l_grey under detail">
	<div class="wrap_contents clearfix">
		<div class="col_left blog">
			<div class="tit_blog_detail">
				<p class="times head_blog">TITLE</p>
				<h2><!--{%$post['post_title']%}--></h2>
				<p class="date"><!--{%$post['post_date']|date_format:"%Y.%m.%d"%}--></p>
				<div class="addthis_inline_share_toolbox_g5mc"></div>
			</div>
			<div class="article_area">
				<div class="wrap_txt">
					<div class="entry_area">
					<!--{%assign var=c value=0%}--> 
					<!--{%if $post['product_view'] != ''%}-->
						<!--{%foreach $post2 as $p%}-->
							<!--{%if !isset($p['brand_name'])%}-->
								<!--{%$p%}-->
							<!--{%else%}-->
							<!--{%if $c == 0%}-->
							<div class="box2">
							<!--{%/if%}-->
							<div class="plist">
							<a href="/mall/<!--{%$p['shop_id']%}-->/item/?detail=<!--{%$p['product_id']%}-->">
							<img src="/upload/images/<!--{%$p['shop_id']%}-->/<!--{%$p['image']%}-->" />
							</a>
							<p class="brand"><!--{%$p['brand_name']%}--></p>
							<p class="price sales">¥<!--{%$p['price01']|number_format%}--></p>
							<p class="shop times"><!--{%$p['shop_name']%}--></p>
							</div>
							<!--{%assign var=c value=$c+1%}--> 
							<!--{%if $c == 2%}-->
							</div>
							<!--{%assign var=c value=0%}--> 
							<!--{%/if%}-->
							<!--{%/if%}-->
						<!--{%/foreach%}-->
						<!--{%if $c > 0%}-->
						</div>
						<!--{%/if%}-->

					<!--{%else%}-->
						<!--{%$post['content']%}-->
					<!--{%/if%}-->
					</div>
				</div>
			</div>
			<div class="pager article_detail blog">
				<!--{%if $prev_next['prev'] != ""%}-->
				<a class="prev" href="?entry=<!--{%$prev_next['prev']['ID']%}-->">
					<p><span></span></p>
					<p class="tit"><!--{%$prev_next['prev']['post_title']%}--></p>
				</a>
				<!--{%/if%}-->
				<!--{%if $prev_next['next'] != ""%}-->
				<a class="next" href="?entry=<!--{%$prev_next['next']['ID']%}-->">
					<p class="tit"><!--{%$prev_next['next']['post_title']%}--></p>
					<p><span></span></p>
				</a>
				<!--{%/if%}-->
			</div>
		</div>

		<!--{%include file='smarty/common/include/blog_side_shop.tpl'%}-->
	</div>
</section>
