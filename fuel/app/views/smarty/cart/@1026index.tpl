<!--{%include file='smarty/common/include/head.tpl'%}-->
<!--{%include file='smarty/common/include/header.tpl'%}-->
<section class="tit_page">
	<h2 class="times">SHOPPING CART</h2>
</section>
<div class="wrap_contents sub">
<!--{%if $stockerror%}-->
<p class="attention"><!--{%$stockerror%}--></p>
<!--{%/if%}-->
	<form>
<!--{%foreach from=$arrItems item=item name=cart%}-->
	<!--{%if $smarty.foreach.cart.first%}-->
		<table class="cart">
			<tr>
				<th>商品</th>
				<th>個数</th>
				<th>小計</th>
			</tr>
	<!--{%/if%}-->
			<tr>
				<td>
					<div class="box_item">
						<!--{%assign var=image value=$item->getImage()%}-->
						<img class="block fl" src="/upload/images/<!--{%$item->getShop()%}-->/<!--{%$image[0].path%}-->">
						<div class="item_detail fr">
							<p class="bold"><!--{%$item->getBrandName()%}--> / <!--{%$item->getBrandNameKana()%}--></p>
							<p class="bold"><!--{%$item->getName()%}--></p>
							<p class="bold">¥<!--{%number_format($item->getPrice())%}--></p>
							<!--{%if $item->getColor() != ''%}-->
							<dl>
								<dt class="bold">カラー：</dt>
								<dd><!--{%$item->getColor()%}--></dd>
							</dl>
							<!--{%/if%}-->
							<!--{%if $item->getSize() != ''%}-->
							<dl>
								<dt class="bold">サイズ：</dt>
								<dd><!--{%$item->getSize()%}--></dd>
							</dl>
							<!--{%/if%}-->
						</div>
					</div>
				</td>
				<td>
					<div class="wrap_select">
						<select name="number" class="number">
							<option value="1" <!--{%if $item->getQuantity() == 1%}-->selected<!--{%/if%}--> data-id="<!--{%$item->getProductId()%}-->" data-color="<!--{%$item->getColorCode()%}-->" data-size="<!--{%$item->getSizeCode()%}-->">1</option>
							<option value="2" <!--{%if $item->getQuantity() == 2%}-->selected<!--{%/if%}--> data-id="<!--{%$item->getProductId()%}-->" data-color="<!--{%$item->getColorCode()%}-->" data-size="<!--{%$item->getSizeCode()%}-->">2</option>
							<option value="3" <!--{%if $item->getQuantity() == 3%}-->selected<!--{%/if%}--> data-id="<!--{%$item->getProductId()%}-->" data-color="<!--{%$item->getColorCode()%}-->" data-size="<!--{%$item->getSizeCode()%}-->">3</option>
							<option value="4" <!--{%if $item->getQuantity() == 4%}-->selected<!--{%/if%}--> data-id="<!--{%$item->getProductId()%}-->" data-color="<!--{%$item->getColorCode()%}-->" data-size="<!--{%$item->getSizeCode()%}-->">4</option>
							<option value="5" <!--{%if $item->getQuantity() == 5%}-->selected<!--{%/if%}--> data-id="<!--{%$item->getProductId()%}-->" data-color="<!--{%$item->getColorCode()%}-->" data-size="<!--{%$item->getSizeCode()%}-->">5</option>
						</select>
					</div>
				</td>
				<td class="border_none">
					<p class="price bold">¥<!--{%(($item->getPrice()*$item->getQuantity())*((TAX_RATE+100)/100))|floor|number_format%}--></p>
					<a class="del_btn underline block" href="javascript:void(0);" data-id="<!--{%$item->getProductId()%}-->" data-color="<!--{%$item->getColorCode()%}-->" data-size="<!--{%$item->getSizeCode()%}-->">削除</a>
				</td>
			</tr>
			<tr><td colspan="3" class="border_none"><hr></td></tr>
	<!--{%if $smarty.foreach.cart.last%}-->
		</table>
	<!--{%/if%}-->
<!--{%/foreach%}-->
<!--{%if $arrItems|count%}-->
		<div class="btn_area">
			<!--{%if $customer%}-->
				<a href="/cart/shopping/" class="submit_sys block confirm">ログインして購入</a>
			<!--{%else%}-->
				<a href="/signin/" class="submit_sys block confirm">ログインして購入</a>
			<!--{%/if%}-->
			<a href="/signup/" class="submit_sys block confirm b_purple">会員登録して購入</a>
			<a class="submit_sys block confirm guest" href="/cart/subscribe">会員登録せずに購入</a>
			<hr>
			<a class="back_sys block" href="/">買い物を続ける</a>
		</div>
<!--{%else%}-->
		<p class="no_item t-center">現在カート内に商品はございません。</p>
		<div class="btn_area">
			<a class="back_sys block" href="/">買い物を続ける</a>
		</div>
<!--{%/if%}-->
	</form>
	<div id="ssl" class="clearfix">
		<span id="ss_gmo_img_wrapper_115-57_image_ja">
			<a href="https://jp.globalsign.com/" target="_blank" rel="nofollow"><img alt="SSL　GMOグローバルサインのサイトシール" border="0" id="ss_img" src="//seal.globalsign.com/SiteSeal/images/gs_noscript_115-57_ja.gif"></a>
		</span>
		<script type="text/javascript" src="//seal.globalsign.com/SiteSeal/gmogs_image_115-57_ja.js" defer="defer"></script>
		<span class="t-left">当サイトはGMOグローバルサイン社のデジタルIDにより証明されています。<br>SSL暗号通信により通信すべてが暗号化されるので、ご記入された内容は安全に送信されます。</span>
	</div>
</div>
<!--{%include file='smarty/common/include/fbnr.tpl'%}-->
<!--{%include file='smarty/common/include/viewed.tpl'%}-->
<!--{%include file='smarty/common/include/pickup.tpl'%}-->
<!--{%include file='smarty/common/include/footer.tpl'%}-->
<script>
$(function(){
	$('.number').change(function(){
			var url = "/api/setcart.json";
			var _product_id = $("option:selected", this).data("id");
			var _color_code = $("option:selected", this).data("color");
			var _size_code = $("option:selected", this).data("size");
			var data = {product_id : _product_id, color_code : _color_code,size_code : _size_code,quantity : $(this).val()};
			var res = sendApi(url, data, cart_view);			
	});
	$('.del_btn').click(function(){
			var url = "/api/delcart.json";
			var _product_id = $(this).data("id");
			var _color_code = $(this).data("color");
			var _size_code = $(this).data("size");
			var data = {product_id : _product_id, color_code : _color_code,size_code : _size_code,quantity : 0};
			var res = sendApi(url, data, cart_reload);
	});
});
function cart_reload(data)
{
	location.reload();
}
function cart_view(data)
{
	if (data != false)
	{
		console.log(JSON.stringify(data));

		$('.num_cart').text(data.quantity);
	}
	location.reload();
}
</script>