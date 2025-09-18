<!--{%include file='smarty/common/include/head.tpl'%}-->
<!--{%include file='smarty/common/include/header.tpl'%}-->
<section class="tit_page">
	<h2 class="times">CONFIRMATION</h2>
</section>
<div class="wrap_contents sub">
  <div class="intro">
  	<h3>ご注文内容の確認</h3>
  	<p>注文内容をご確認の上、よろしければ「購入する」ボタンを押して下さい。<br>
    	お支払い方法にクレジットカード決済や各種ペイメントを選ばれたお客様は、決済ページへと進みます。</p>
  </div>

	<!-- suzuki mod start -->
	<form name="form1" action="<!--{%$url_multi_entry%}-->" method="POST">
	<!-- suzuki mod end -->
		<table class="cart confirm">
			<tr>
				<th>商品</th>
				<th>個数</th>
				<th>小計</th>
			</tr>
<!--{%foreach from=$arrItems item=item name=cart%}-->
			<tr>
				<td>
					<div class="box_item">
						<!--{%assign var=image value=$item->getImage()%}-->
						<img class="block fl" src="/upload/images/<!--{%if $item->getOrgShop()%}--><!--{%$item->getOrgShop()%}--><!--{%else%}--><!--{%$item->getShop()%}--><!--{%/if%}-->/<!--{%$image[0].path%}-->">
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
					<!--{%$item->getQuantity()%}-->
				</td>
				<td class="border_none">
					<p class="price bold">¥<!--{%($item->getPrice()*(TAX_RATE+100)/100)|floor|number_format%}--></p>
				</td>
			</tr>
			<tr><td colspan="3" class="border_none"><hr></td></tr>
<!--{%/foreach%}-->


      <tr>
  		<td colspan="3" class="child_wrapper">
        <table class="cart child" style="border-spacing: 0 15px;">
          <tr>
    				<td class="price_info">
      				<p class="fl">ご使用ポイント（1pt = ¥1）</p>
            </td>
			<!-- suzuki mod start -->
            <td class="price"><span><!--{%$point_use_amount%}--></span></td>
			<!-- suzuki mod end -->
          </tr>
          <!--{%if $coupon_price%}-->
          <tr><td colspan="2" class="border_none"><hr></td></tr>
          <tr>
    				<td class="price_info">
      				<p class="fl">クーポン</p>
            </td>
            <td class="price"><span>- ¥<!--{%$coupon_price|number_format%}--></span></td>
          </tr>
          <!--{%/if%}-->
          <!--{%if $coupon_product%}-->
          <tr><td colspan="2" class="border_none"><hr></td></tr>
          <tr>
    				<td class="price_info">
      				<p class="fl">クーポン無料商品</p>
            </td>
            <td class="price"><span><!--{%$coupon_product%}--></span></td>
          </tr>
          <!--{%/if%}-->
          <tr><td colspan="2" class="border_none"><hr></td></tr>
          <tr>
    				<td class="price_info">
      				<p class="fl">送料</p>
            </td>
            <td class="price"><span>¥<!--{%Tag_Util::taxin_cal($deliv_fee)|number_format%}--></span></td>
          </tr>
          <tr><td colspan="2" class="border_none"><hr></td></tr>
          <!--{%if $paymemt_type_str == '代金引換'%}-->
          <tr>
    				<td class="price_info">
      				<p class="fl">代引手数料</p>
            </td>
            <td class="price"><span>¥<!--{%Tag_Util::taxin_cal($fee)|number_format%}--></span></td>
          </tr>
          <tr><td colspan="2" class="border_none"><hr></td></tr>
          <!--{%/if%}-->
          <tr>
    				<td class="price_info">
      				<p class="fl">ギフトラッピング</p>
            </td>
			<!-- suzuki mod start -->
            <td class="price"><span>¥<!--{%Tag_Util::taxin_cal($lapping_amount)|number_format%}--></span></td>
			<!-- suzuki mod end -->
          </tr>
          <tr class="total">
    				<td class="price_info total_price">
      				<p class="fl">合計（税込）</p>
            </td>
            <td class="price"><span>¥<!--{%$arrOrder->getAmount()|number_format%}--></span></td>
          </tr>
          <!--{%if $member_id%}-->
          <tr>
    				<td class="price_info">
      				<p class="fl">加算ポイント</p>
            </td>
            <td class="price"><span>+ <!--{%$point_add%}-->pt</span></td>
          </tr>
          <!--{%/if%}-->
          <tr><td colspan="2" class="border_none"><hr></td></tr>
        </table>
  		</td>
		</tr>
		</table>
		<!-- suzuki add style="" -->	
    	<div class="btn_area" style="<!--{%$btn_disp_non_amazonpay%}-->">
    	<!--{%if $payment_type == 5%}-->
<button class="submit_sys block confirm btn_img rakuten">
<img src="https://checkout.rakuten.co.jp/p/common/img/btn_check_12.gif" alt="楽天ペイでお支払い">
</button>
    	<!--{%else%}-->
			<button class="submit_sys block confirm">購入する</button>
    	<!--{%/if%}-->
			<!-- suzuki add onclick="" -->
			<a href="" class="back_sys block" onclick="document.form1.action='./payment';document.form1.submit();">戻る</a>
		</div>
	<!-- </form> suzuki move -->	
    <h3 class="single">お届け先</h3>
		<table class="form confirm">
			<tbody><tr>
				<th>お名前</th>
				<!-- suzuki mod start -->
				<td><!--{%$customer_name%}--></td>
				<!-- suzuki mod end -->
			</tr>
			<tr>
				<th>フリガナ</th>
				<!-- suzuki mod start -->
				<td><!--{%$customer_kana%}--></td>
				<!-- suzuki mod end -->
			</tr>
			<tr>
				<th>会社名</th>
				<!-- suzuki mod start -->
				<td><!--{%$company%}--></td>
				<!-- suzuki mod end -->
			</tr>
			<tr>
				<th>部署名</th>
				<!-- suzuki mod start -->
				<td><!--{%$section%}--></td>
				<!-- suzuki mod end -->
			</tr>
			<tr>
				<th>郵便番号</th>
				<!-- suzuki mod start -->
				<td><!--{%$zip%}--></td>
				<!-- suzuki mod end -->
				</tr>
			<tr>
				<th>住所</th>
				<!-- suzuki mod start -->
				<td><!--{%$address%}--></td>
				<!-- suzuki mod end -->
				</tr>
			<tr>
				<th>電話番号</th>
				<!-- suzuki mod start -->
				<td><!--{%$tel_number%}--></td>
				<!-- suzuki mod end -->
				</tr>
		</tbody>
		</table>
    <h3 class="single">ご注文詳細</h3>
		<table class="form confirm">
			<tbody>
<!-- suzuki del
			<tr>
				<th>配送業者</th>
				<td>ヤマト運輸</td>
			</tr>
-->
			<tr>
				<th>お支払い方法</th>
				<!-- suzuki mod start -->
				<td><!--{%$paymemt_type_str%}--></td>
				<!-- suzuki mod end -->
			</tr>
			<tr>
				<th>お届け日時</th>
				<!-- suzuki mod start -->
				<td><!--{%$arrDate[$delivery_day]%}--> <!--{%$arrTime[$delivery_time]%}--></td>
				<!-- suzuki mod end -->
			</tr>
			<tr>
				<th>明細書</th>
				<!-- suzuki mod start -->
				<td><!--{%$specification_str%}--></td>
				<!-- suzuki mod end -->
			</tr>
			<tr>
				<th>領収書</th>
				<!-- suzuki mod start -->
				<td>宛名：<!--{%$receipt_name%}--><br>但し書：<!--{%$receipt_tadashi%}--></td>
				<!-- suzuki mod end -->
			</tr>
			<tr>
				<th>ギフトラッピング</th>
				<!-- suzuki mod start -->
				<td><!--{%$lapping%}--></td>
				<!-- suzuki mod end -->
			</tr>
			<tr>
				<th>メッセージカード</th>
				<!-- suzuki mod start -->
				<td><!--{%$msg_card_str%}--><!--{%$msg_card_dtl%}--></td>
				<!-- suzuki mod end -->
			</tr>
			<tr>
				<th>簡易包装</th>
				<!-- suzuki mod start -->
				<td><!--{%$simple_package%}--></td>
				<!-- suzuki mod end -->
			</tr>
			<tr>
				<th>備考</th>
				<!-- suzuki mod start -->
				<td><!--{%$msg_contact%}--></td>
				<!-- suzuki mod end -->
			</tr>

		</tbody>
		</table>

		<!-- suzuki add start -->
		<div class="btn_area" style="<!--{%$btn_disp_amazonpay%}-->">
			<div align="center" id="AmazonPayButton"></div><br>
			<!--
			<div align="center">
			<label style="font-size: 14px;line-height: 23px;">Amazonアカウントでお支払いの方はこちらからお進みください。<br><br></label>
			</div>
			-->
			<a href="" class="back_sys block" onclick="document.form1.action='./payment';document.form1.submit();">戻る</a>
		</div>
		<!-- suzuki add end -->
		<!-- suzuki add style="" -->
    	<div class="btn_area" style="<!--{%$btn_disp_non_amazonpay%}-->">
    	<!--{%if $payment_type == 5%}-->
<button class="submit_sys block confirm btn_img rakuten">
<img src="https://checkout.rakuten.co.jp/p/common/img/btn_check_12.gif" alt="楽天ペイでお支払い">
</button>
    	<!--{%else%}-->
			<button class="submit_sys block confirm">購入する</button>
    	<!--{%/if%}-->

			<!-- suzuki add onclick="" -->
			<a href="" class="back_sys block" onclick="document.form1.action='./payment';document.form1.submit();">戻る</a>
		</div>
<!-- suzuki add start -->
<!--{%$gmo_entry_param%}-->
<!-- suzuki add end -->
	</form>		<!-- suzuki move -->	
	
		<div id="ssl" class="clearfix">
		<span id="ss_gmo_img_wrapper_115-57_image_ja">
			<a href="https://jp.globalsign.com/" target="_blank" rel="nofollow"><img alt="SSL　GMOグローバルサインのサイトシール" border="0" id="ss_img" src="//seal.globalsign.com/SiteSeal/images/gs_noscript_115-57_ja.gif"></a>
		</span>
		<script type="text/javascript" src="//seal.globalsign.com/SiteSeal/gmogs_image_115-57_ja.js" defer="defer"></script>
		<span class="t-left">当サイトはGMOグローバルサイン社のデジタルIDにより証明されています。<br>SSL暗号通信により通信すべてが暗号化されるので、ご記入された内容は安全に送信されます。</span>
	</div>
</div>


<!-- suzuki add start -->
<!-- ↓Amazon Pay JavaScript -->
<script type='text/javascript'>
			let clientId = "<!--{%$client_id%}-->"; 
			let sellerId = "<!--{%$merchant_id%}-->";

			// Amazonログインコールバック
			window.onAmazonLoginReady = function() {
				amazon.Login.setClientId(clientId);
				amazon.Login.setUseCookie(false); //popup=falseにときに必要
			};
			// Amazonペイメントコールバック
			window.onAmazonPaymentsReady = function() {
				// ボタン表示
				showLoginButton();
			};
			// AmazonPayボタン
			function showLoginButton() {
				var authRequest;
					OffAmazonPayments.Button(
						"AmazonPayButton",
						sellerId, {
							type:  "PwA",		// AmazonPayボタンの種類（PwA、LwA）PwA：AmazonPay、LwA：AmazonLogin
							color: "Gold",	// AmazonPayボタンの色（Gold、LightGray、DarkGray）
							size:  "large",	// AmazonPayボタンのサイズ（small、medium、large、x-large）
							// 認証
							authorization: function() {
									loginOptions = {
										scope: "profile payments:widget payments:shipping_address",
										popup: true	// ログイン画面はポップアップ表示させる
									};
									authRequest = amazon.Login.authorize (
										loginOptions,
										"<!--{%$url_amazonpay%}-->"
									);
							},
							onError: function(error) {
									//document.getElementById("errorCode").innerHTML = error.getErrorCode();
									//document.getElementById("errorMessage").innerHTML = error.getErrorMessage();
							}
			}
		);
			}
</script>

<!-- ウィジェット追加 -->
<script type="text/javascript" src="<!--{%$url_widget_js%}-->" async="async">
</script>

<!-- Amazon認証ログアウト
<script type="text/javascript">
	document.getElementById('Logout'].onclick = function() {
		amazon.Login.logout();
	}
</script>
-->
<!-- ↑Amazon Pay JavaScript -->
<!-- suzuki add end -->


<!--{%include file='smarty/common/include/fbnr.tpl'%}-->
<!--{%include file='smarty/common/include/footer.tpl'%}-->
