<section class="sec_2col l_grey under">
	<div class="wrap_contents clearfix">
		<div class="col_left">
			<div class="head_01 clearfix">
				<h2 class="times"><!--{%if $order =="rank"%}-->RANKING<!--{%else%}-->LATEST<!--{%/if%}--></h2>
				<ul class="times fr block">
					<!--{%assign var=mallurl value=""%}-->
					<!--{%if $mall != ""%}-->
						<!--{%assign var=mallurl value="/mall/`$mall`"%}-->
					<!--{%/if%}-->
					<li><a href="" data-mall="<!--{%$mallurl%}-->" data-order="" class="btn_order <!--{%if $order ==""%}-->active<!--{%/if%}-->">LATEST</a></li>
					<li><a href="" data-mall="<!--{%$mallurl%}-->" data-order="rank" class="btn_order <!--{%if $order =="rank"%}-->active<!--{%/if%}-->">RANKING</a></li>
				</ul>
			</div>
			<div class="load_list">
				<!--{%foreach $arrFeature['arrPosts'] as $post%}-->
				<a class="cel_feature block" href="<!--{%$mallurl%}-->/feature/?entry=<!--{%$post['ID']%}-->">
					<img class="block" src="<!--{%$post['thumb_url']%}-->" alt="<!--{%$post['title2']|replace:'[BR]':''%}-->">
					<div class="tit_feature">
						<h3><span class="times"><!--{%$post['post_title']|replace:'[BR]':'<br/>'%}--></span><!--{%$post['title2']|replace:'[BR]':'<br/>'%}--></h3>
						<p class="date"><!--{%$post['post_date']|date_format:"%Y.%m.%d"%}--><!--{%if $post['pr']%}--><span>　｜　Promotion</span><!--{%/if%}--></p>
					</div>
				</a>
				<!--{%/foreach%}-->
			</div>
			<!--{%if 1 < $arrFeature['maxPageNum']%}-->
				<!--{%if $arrFeature['pageNum'] == ""%}-->
					<!--{%assign var=next_page value=1%}-->
				<!--{%else%}-->
					<!--{%assign var=next_page value=$arrFeature['pageNum']+1%}-->
				<!--{%/if%}-->
				<a id="btn_more" href="?page=<!--{%$next_page%}-->&order=<!--{%$order%}-->" class="btn_more times" onclick="return false;">LOAD MORE<i class="icon-arrow_down"></i></a>
				<p id="loading" class="t-center loading"><img src="/common/images/ico/ajax-loader.gif" alt="loading"></p>
				<input type="hidden" id="loading_max_page" value="<!--{%$arrFeature['maxPageNum']%}-->" />
			<!--{%/if%}-->
		</div>

		<!--{%include file='smarty/common/include/brshop/feature_side_shop.tpl'%}-->
	</div>
</section>
