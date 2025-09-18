<!--{%include file='smarty/common/include/head.tpl'%}-->
<!--{%include file='smarty/common/include/header.tpl'%}-->
<section class="tit_page">
	<h2 class="times">PAYMENT</h2>
</section>
<div class="wrap_contents sub">
(DEBUG)order_id=<!--{%$order_id%}--><br>
(DEBUG)amount=<!--{%$amount%}--><br>
(DEBUG)member_id=<!--{%$member_id%}--><br>
  <div class="intro">
  	<h3>お支払い方法・お届け日時の指定</h3>
  </div>

	<form>

  <div class="payment sub-title">
    <p>配送業者</p>
  </div>
  <table class="option payment">
    <tbody>
			<tr>
				<td>
  				<div class="wrap_radio">
						<input type="radio" name="add" value="add_01" id="add_01" required="">
						<label for="add_01"></label>
  				</div>
				</td>
				<td class="payment_info">
  				<p class="bold">ヤマト運輸</p>
				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
		</tbody>
  </table>

  <div class="payment sub-title">
    <p>お支払い方法</p>
  </div>
  <table class="option payment">
    <tbody>
			<tr>
				<td>
  				<div class="wrap_radio">
						<input type="radio" name="payment_type" value="type_01" id="type_01" required="">
						<label for="type_01"></label>
  				</div>
				</td>
				<td class="payment_info border_none">

          <ul class="drawer-menu">
            <li class="mainmenu">
              <div class="toggle">
                <p class="tit_menu">クレジットカード決済</p>
                <p class="plus"><span></span><span></span></p>
              </div>
            <ul class="menulist drawer-dropdown-menu" style="display: none;">
            <li>
              <div>
                <img class="rpay" src="/common/images/ico/card.jpg">
                <p>
	                VISA、MASTER、JCB、AMEX ： 一括払い、分割払い、リボ払いのみ。<br>
					DINERS ： 一括払い、リボ払いのみ。<br>
					※ 2回払い、ボーナス一括払いはいずれもご利用頂けません。
				</p>
              </div>
            </li>
          </ul>
            </li>
          </ul>

				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
			<tr>
				<td>
  				<div class="wrap_radio">
						<input type="radio" name="payment_type" value="type_02" id="type_02" required="">
						<label for="type_02"></label>
  				</div>
				</td>
				<td class="payment_info border_none">
        <ul class="drawer-menu">
          <li class="mainmenu">
            <div class="toggle">
            <p class="tit_menu">銀行振込</p>
            <p class="plus"><span></span><span></span></p>
          </div>
            <ul class="menulist drawer-dropdown-menu" style="display: none;">
            <li>
              <div>
                <p>
	                ご注文日から3営業日以内（土、日、祝日は除く）に下記振込先へご入金ください。<br>
					＜お振込指定口座＞<br>
					みずほ銀行 青山支店 普通口座 2006926<br>
					口座名 ： カ)ビー.アール.ティー<br>
					※ 振込口座情報はご注文確認メールにも記載いたします。
				</p>
              </div>
            </li>
          </ul>
        </ul>
        </div>
				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
			<tr>
				<td>
  				<div class="wrap_radio">
						<input type="radio" name="payment_type" value="type_03" id="type_03" required="">
						<label for="type_03"></label>
  				</div>
				</td>
				<td class="payment_info border_none">
        <ul class="drawer-menu">
          <li class="mainmenu">
            <div class="toggle">
            <img src="../common/images/system/pay_amazon@2x.png" alt="amazon pay" class="icon">
            <p class="tit_menu pos01">アマゾンペイ</p>
            <p class="plus"><span></span><span></span></p>
          </div>
            <ul class="menulist drawer-dropdown-menu" style="display: none;">
            <li>
              <div>
                <p>Amazonにアカウントをお持ちのお客様は、Amazon.co.jpにご登録のお支払い方法を利用してお買い物が可能です。また、B.R.ONLINE会員様はB.R.ONLINEのポイントが貯まります。B.R.ONLINEでの使用も可能です。<br>※Amazonポイントとは連携しておりません。</p>
              </div>
            </li>
          </ul>
          </li>
        </ul>
				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
			<tr>
				<td>
  				<div class="wrap_radio">
						<input type="radio" name="payment_type" value="type_04" id="type_04" required="">
						<label for="type_04"></label>
  				</div>
				</td>
				<td class="payment_info border_none">
        <ul class="drawer-menu">
          <li class="mainmenu">
            <div class="toggle">
            <img src="../common/images/system/pay_rpay@2x.png" alt="楽天Pay" class="icon">
            <p class="tit_menu pos01">楽天Pay</p>
            <p class="plus"><span></span><span></span></p>
          </div>
            <ul class="menulist drawer-dropdown-menu" style="display: none;">
            <li>
              <div>
                <p>いつもの楽天IDとパスワードを使ってスムーズなお支払いが可能です。<br>
                楽天ポイントが貯まる・使える！「簡単」「あんしん」「お得」な楽天ペイをご利用ください。</p>
                <img src="../common/images/system/pay_rpay_bnr@2x.png" alt="" class="rpay">
              </div>
            </li>
          </ul>
          </li>
        </ul>
				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
			<tr>
				<td>
  				<div class="wrap_radio">
						<input type="radio" name="payment_type" value="type_04" id="type_05" required="">
						<label for="type_05"></label>
  				</div>
				</td>
				<td class="payment_info border_none">
        <ul class="drawer-menu">
          <li class="mainmenu">
            <div class="toggle">
            <img src="../common/images/system/pay_apple@2x.png" alt="Apple Pay" class="icon">
            <p class="tit_menu pos01">Apple Pay</p>
            <p class="plus"><span></span><span></span></p>
          </div>
            <ul class="menulist drawer-dropdown-menu" style="display: none;">
            <li>
              <div>
                <p>いつもの楽天IDとパスワードを使ってスムーズなお支払いが可能です。<br>
                楽天ポイントが貯まる・使える！「簡単」「あんしん」「お得」な楽天ペイをご利用ください。</p>
                <img src="../common/images/system/pay_rpay_bnr@2x.png" alt="" class="rpay">
              </div>
            </li>
          </ul>
          </li>
        </ul>
				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
		</tbody>
  </table>

  <div class="payment sub-title">
    <p>クーポンコード</p>
  </div>
  <table class="option payment">
    <tbody>
			<tr>
				<td class="payment_info cupon">
  				<input type="text" class="cupon_code" name="cupon_code" placeholder="例　ABc12345efGh678（半角英数字）" required="">
				</td>
			</tr>
		</tbody>
  </table>

  <div class="payment sub-title">
    <p>ポイントのご使用</p>
  </div>
  <table class="option payment none-mb">
    <tbody>
			<tr>
				<td>
  				<div class="wrap_radio">
						<input type="radio" name="point_use" value="point_use_yes" id="point_use_yes" required="">
						<label for="point_use_yes"></label>
  				</div>
				</td>
				<td class="payment_info">
  				<p class="mb20">現在の有効ポイント：　<span class="bold">00000</span> ポイント</p>
  				<input type="text" class="point_use" name="point_use" placeholder="00000" required=""> <span class="bold">ポイントを使用する</span>
				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
			<tr>
				<td>
  				<div class="wrap_radio">
						<input type="radio" name="point_use" value="point_use_no" id="point_use_no" required="">
						<label for="point_use_no"></label>
  				</div>
				</td>
				<td class="payment_info">
  				<p class="bold">ポイントを使用しない</p>
				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
		</tbody>
  </table>
  <p class="repletion">「1ポイントを1円」として使用する事ができます。<br>
    使用する場合は、「ポイントを使用する」にチェックを入れた後、使用するポイントをご記入ください。</p>

  <div class="payment sub-title">
    <p>お届け日時の指定</p>
  </div>
  <table class="option payment none-mb">
    <tbody>
			<tr>
				<td class="payment_heading">配達希望日</td>
				<td class="payment_info">
          <div class="wrap_select">
						<select name="delivery_day" id="delivery_day" class="col1">
							<option value="" selected="">指定しない</option>
							<option value="">0000年00月00日</option>
							<option value="">0000年00月00日</option>
							<option value="">0000年00月00日</option>
							<option value="">0000年00月00日</option>
							<option value="">0000年00月00日</option>
							<option value="">0000年00月00日</option>
							<option value="">0000年00月00日</option>
							<option value="">0000年00月00日</option>
							<option value="">0000年00月00日</option>
							<option value="">0000年00月00日</option>
						</select>
					</div>
				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
			<tr>
				<td class="payment_heading">お届け時間</td>
				<td class="payment_info">
          <div class="wrap_select">
						<select name="delivery_time" id="delivery_time" class="col1">
							<option value="" selected="">指定しない</option>
							<option value="">00:00〜00:00</option>
							<option value="">00:00〜00:00</option>
							<option value="">00:00〜00:00</option>
							<option value="">00:00〜00:00</option>
							<option value="">00:00〜00:00</option>
							<option value="">00:00〜00:00</option>
							<option value="">00:00〜00:00</option>
							<option value="">00:00〜00:00</option>
							<option value="">00:00〜00:00</option>
							<option value="">00:00〜00:00</option>
						</select>
					</div>
				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
		</tbody>
  </table>
  <p class="repletion">お届け日・お届け時間はあくまで目安となっております。指定をいただいても交通事情等により遅れる場合もございます。</p>

  <div class="payment sub-title">
    <p>明細書</p>
  </div>
  <table class="option payment none-mb">
    <tbody>
			<tr>
				<td>
  				<div class="wrap_radio">
						<input type="radio" name="specification" value="specification_yes" id="specification_yes" required="">
						<label for="specification_yes"></label>
  				</div>
				</td>
				<td class="payment_info">
  				<p class="bold">お買い上げ明細を同封する</p>
				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
			<tr>
				<td>
  				<div class="wrap_radio">
						<input type="radio" name="specification" value="specification_no" id="specification_no" required="">
						<label for="specification_no"></label>
  				</div>
				</td>
				<td class="payment_info">
  				<p class="bold">お買い上げ明細を同封しない</p>
				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
		</tbody>
  </table>
  <p class="repletion">プレゼントなど、明細の同封が不要の場合は、「お買い上げ明細を同封しない」にチェックをつけてください。</p>

  <div class="payment sub-title">
    <p>領収書</p>
  </div>
  <table class="option payment none-mb">
    <tbody>
			<tr>
				<td class="payment_heading">領収書宛名</td>
				<td class="payment_info">
  				<input type="text" class="receipt" name="receipt_name" placeholder="例　株式会社○○○○○" required="">
				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
			<tr>
        <td class="payment_heading">領収書但し</td>
				<td class="payment_info">
  				<input type="text" class="receipt" name="receipt_tadashi" placeholder="例　お品代として" required="">
				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
		</tbody>
  </table>
  <p class="repletion">代金引換をご利用された場合、領収書は配送会社発行のものとなり、宛名はお届け先と同様になります。</p>

  <div class="payment sub-title">
    <p>ギフトラッピング</p>
  </div>
  <table class="option payment giftwrapping">
    <tbody>
			<tr>
				<td class="payment_heading">簡易包装</td>
				<td class="payment_info">
  				<div class="wrap_select">
						<select name="delivery_day" id="delivery_day" class="col1">
							<option value="" selected="">簡易包装を希望しない</option>
							<option value="">簡易包装を希望する</option>
						</select>
					</div>

				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
			<tr>
        <td class="payment_heading">ギフトラッピング</td>
				<td class="payment_info">
  				<div class="wrap_select gift">
						<select name="delivery_day" id="delivery_day" class="col1">
							<option value="" selected="">ギフトラッピングなし</option>
							<option value="">ギフトラッピングする</option>
						</select>
					</div>
				<span class="gift">（有料：324円）</span>
				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
			<tr>
        <td class="payment_heading">メッセージカード</td>
				<td class="payment_info">
  				<div class="wrap_select gift">
						<select name="delivery_day" id="delivery_day" class="col1">
							<option value="" selected="">メッセージカードなし</option>
							<option value="">メッセージカードあり</option>
						</select>
					</div>
				<span class="gift">（無料）</span>
				<textarea class="msg gift" name="" maxlength="50" placeholder="メッセージの内容をご記入ください（50字以内）"></textarea>
				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
		</tbody>
  </table>

  <div class="payment sub-title">
    <p>備考</p>
  </div>
  <table class="option payment">
    <tbody>
			<tr>
        <td class="payment_heading">ご希望・ご連絡等</td>
				<td class="payment_info">
				<textarea class="msg contact" name="" maxlength="50" placeholder="その他お問い合わせ事項がございましたら、こちらにご入力ください。"></textarea>
				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
		</tbody>
  </table>
	</form>	

    <div class="btn_area">
			<!-- suzuki add start -->
			<div align="center" id="AmazonPayButton"></div>
			<div align="center">
			<label style="font-size: 14px;line-height: 23px;">Amazonアカウントでお支払いの方はこちらからお進みください。<br><br></label>
			</div>
			<!-- suzuki add end -->
			<!-- suzuki mod start -->
			<button class="submit_sys block confirm" onclick="location.href='./confirm'">次へ</button>
			<!-- suzuki mod end -->
			<a href="" class="back_sys block">戻る</a>
		</div>	
	
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
