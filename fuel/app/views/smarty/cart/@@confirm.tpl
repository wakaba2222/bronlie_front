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
(DEBUG)order_id=<!--{%$order_id%}--><br>
(DEBUG)amount=<!--{%$amount%}--><br>
(DEBUG)member_id=<!--{%$member_id%}--><br>
(DEBUG)url_capture=<!--{%$url_capture%}--><br>
(DEBUG)orderReferenceId=<!--{%$orderReferenceId%}--><br>
(DEBUG)zip=<!--{%$zip%}--><br>
(DEBUG)address=<!--{%$address%}--><br>
(DEBUG)company=<!--{%$company%}--><br>
(DEBUG)tel_number=<!--{%$tel_number%}--><br>
	<form action="<!--{%$url_capture%}-->" method="POST">
		<table class="cart confirm">
			<tr>
				<th>商品</th>
				<th>個数</th>
				<th>小計</th>
			</tr>
			<tr>
				<td>
					<div class="box_item">
						<img class="block fl" src="/common/images/item/thum_item_01.jpg">
						<div class="item_detail fr">
							<p class="bold">Cruciani / クルチアーニ</p>
							<p class="bold">2B ニットジャケット (ミラノリブ) / ストレッチコットン</p>
							<p class="bold">¥130,680</p>
							<dl>
								<dt class="bold">カラー：</dt>
								<dd>ネイビー</dd>
							</dl>
							<dl>
								<dt class="bold">サイズ：</dt>
								<dd>46</dd>
							</dl>
						</div>
					</div>
				</td>
				<td>1</td>
				<td class="border_none">
					<p class="price bold">¥130,680</p>
				</td>
			</tr>
			<tr><td colspan="3" class="border_none"><hr></td></tr>
			<tr>
				<td>
					<div class="box_item">
						<img class="block fl" src="/common/images/item/thum_item_01.jpg">
						<div class="item_detail fr">
							<p class="bold">Cruciani / クルチアーニ</p>
							<p class="bold">2B ニットジャケット (ミラノリブ) / ストレッチコットン</p>
							<p class="bold">¥130,680</p>
							<dl>
								<dt class="bold">カラー：</dt>
								<dd>ネイビー</dd>
							</dl>
							<dl>
								<dt class="bold">サイズ：</dt>
								<dd>46</dd>
							</dl>
						</div>
					</div>
				</td>
				<td>1</td>
				<td class="border_none">
					<p class="price bold">¥130,680</p>
				</td>
			</tr>
			<tr><td colspan="3" class="border_none"><hr></td></tr>
			<tr>
				<td>
					<div class="box_item">
						<img class="block fl" src="/common/images/item/thum_item_01.jpg">
						<div class="item_detail fr">
							<p class="bold">Cruciani / クルチアーニ</p>
							<p class="bold">2B ニットジャケット (ミラノリブ) / ストレッチコットン</p>
							<p class="bold">¥130,680</p>
							<dl>
								<dt class="bold">カラー：</dt>
								<dd>ネイビー</dd>
							</dl>
							<dl>
								<dt class="bold">サイズ：</dt>
								<dd>46</dd>
							</dl>
						</div>
					</div>
				</td>
				<td>1</td>
				<td class="border_none">
					<p class="price bold">¥130,680</p>
				</td>
			</tr>
      <tr><td colspan="3" class="border_none"><hr></td></tr>
      <tr>
  		<td colspan="3" class="child_wrapper">
        <table class="cart child" style="border-spacing: 0 15px;">
          <tr>
    				<td class="price_info">
      				<p class="fl">ご使用ポイント（1pt = ¥1）</p>
            </td>
            <td class="price"><span>- ¥500</span></td>
          </tr>
          <tr><td colspan="2" class="border_none"><hr></td></tr>
          <tr>
    				<td class="price_info">
      				<p class="fl">クーポン</p>
            </td>
            <td class="price"><span>- ¥1,000</span></td>
          </tr>
          <tr><td colspan="2" class="border_none"><hr></td></tr>
          <tr>
    				<td class="price_info">
      				<p class="fl">送料</p>
            </td>
            <td class="price"><span>¥0</span></td>
          </tr>
          <tr><td colspan="2" class="border_none"><hr></td></tr>
          <tr>
    				<td class="price_info">
      				<p class="fl">代引手数料</p>
            </td>
            <td class="price"><span>¥300</span></td>
          </tr>
          <tr><td colspan="2" class="border_none"><hr></td></tr>
          <tr>
    				<td class="price_info">
      				<p class="fl">ギフトラッピング</p>
            </td>
            <td class="price"><span>¥300</span></td>
          </tr>
          <tr class="total">
    				<td class="price_info total_price">
      				<p class="fl">合計（税込）</p>
            </td>
            <td class="price"><span>¥2,130,680</span></td>
          </tr>
          <tr>
    				<td class="price_info">
      				<p class="fl">加算ポイント</p>
            </td>
            <td class="price"><span>+ 500pt</span></td>
          </tr>
          <tr><td colspan="2" class="border_none"><hr></td></tr>
        </table>
  		</td>
		</tr>
		</table>
    <div class="btn_area">
			<button class="submit_sys block confirm" type="submit">購入する</button>
			<a href="" class="back_sys block">戻る</a>
		</div>
	<!-- </form> -->	
    <h3 class="single">お届け先</h3>
		<table class="form confirm">
			<tbody><tr>
				<th>お名前</th>
				<td>山田　太郎</td>
			</tr>
			<tr>
				<th>フリガナ</th>
				<td>ヤマダ　タロウ</td>
			</tr>
			<tr>
				<th>お名前</th>
				<td>山田　太郎</td>
			</tr>
			<tr>
				<th>会社名</th>
				<td><!--{%$company%}--></td>
			</tr>
			<tr>
				<th>部署名</th>
				<td></td>
			</tr>
			<tr>
				<th>郵便番号</th>
				<td><!--{%$zip%}--></td>
			</tr>
			<tr>
				<th>住所</th>
				<td><!--{%$address%}--></td>
			</tr>
			<tr>
				<th>電話番号</th>
				<td><!--{%$tel_number%}--></td>
			</tr>
		</tbody>
		</table>
    <h3 class="single">ご注文詳細</h3>
		<table class="form confirm">
			<tbody><tr>
				<th>配送業者</th>
				<td>ヤマト運輸</td>
			</tr>
			<tr>
				<th>お支払い方法</th>
				<td>クレジットカード決済</td>
			</tr>
			<tr>
				<th>お届け日時</th>
				<td>2018年1月1日 (月)　18〜20時</td>
			</tr>
			<tr>
				<th>明細書</th>
				<td>同封する</td>
			</tr>
			<tr>
				<th>領収書</th>
				<td>宛名：<br>
  				但し書：</td>
			</tr>
			<tr>
				<th>簡易包装</th>
				<td>希望しない</td>
			</tr>
			<tr>
				<th>ギフトラッピング</th>
				<td>希望しない</td>
			</tr>
			<tr>
				<th>メッセージカード</th>
				<td>希望する<br>
  				内容：お誕生日おめでとう</td>
			</tr>
			<tr>
				<th>備考</th>
				<td></td>
			</tr>

		</tbody>
		</table>

    <div class="btn_area">
			<button class="submit_sys block confirm" type="submit">購入する</button>
			<a href="" class="back_sys block">戻る</a>
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
<!--{%include file='smarty/common/include/fbnr.tpl'%}-->
<!--{%include file='smarty/common/include/footer.tpl'%}-->
