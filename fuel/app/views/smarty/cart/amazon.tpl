<!--{%include file='smarty/common/include/head.tpl'%}-->
<!--{%include file='smarty/common/include/header.tpl'%}-->
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<meta name="robots" content="noindex,nofollow,noarchive" />
<!--
<link rel="stylesheet" href="/amzn/css/uikit.min.css"/>
<link rel="stylesheet" href="/amzn/css/uikit-rtl.min.css"/>
<link rel="stylesheet" href="/amzn/css/common.css"/>
-->
<style>
table
{
	padding-bottom:20px;
	margin-bottom:20px;
	width:100%;
}
td
{
	width:50%;
}
h3
{
	font-weight:bold;
}
button.command
{
	background: #B2B2B2;
    line-height: 1.5;
    color:#fff;
    padding:5px 10px;
    margin-left:30px;
}
</style>

<section class="tit_page">
	<h2 class="times">Amazon pay</h2>
</section>
<div class="wrap_contents sub">
<!-- <h3>注文者情報</h3> -->
<table>
    <!--<tr>-->
    <!--    <td>Name:</td><td><div id="buyerName"></div></td>-->
    <!--</tr>-->
<!--
    <tr>
        <td>お名前</td><td><div id="ba_addressName"></div></td>
    </tr>
    <tr>
        <td>メールアドレス</td><td><div id="buyerEmail"></div></td>
    </tr>
    <tr>
        <td>郵便番号</td><td><div id="ba_addressZipcode"></div></td>
    </tr>
    <tr>
        <td>都道府県名</td><td><div id="ba_addressStageOrRegion"></div></td> 
    </tr>
    <tr>
        <td>住所１</td><td><div id="ba_addressLine1"></div></td>
    </tr>
    <tr>
        <td>住所２</td><td><div id="ba_addressLine2"></div></td>
    </tr>
    <tr>
        <td>住所３</td><td><div id="ba_addressLine3"></div></td>
    </tr>
    <tr>
        <td>電話番号</td><td><div id="ba_phoneNumber"></div></td>
    </tr>
-->
</table>
<hr>
<h3 style="display:none;">
    お届け先
    <button id="updateCheckoutDetailsAddress" class="command" type="button">変更</button>
</h3>
<table style="display:none;">
    <tr>
        <td>お名前</td><td><div id="addressName"></div></td>
    </tr>
    <tr>
        <td>郵便番号</td><td><div id="addressZipcode"></div></td>
    </tr>
    <tr>
        <td>都道府県名</td><td><div id="addressStageOrRegion"></div></td> 
    </tr>
    <tr>
        <td>住所１</td><td><div id="addressLine1"></div></td>
    </tr>
    <tr>
        <td>住所２</td><td><div id="addressLine2"></div></td>
    </tr>
    <tr>
        <td>住所３</td><td><div id="addressLine3"></div></td>
    </tr>
    <tr>
        <td>電話番号</td><td><div id="phoneNumber"></div></td>
    </tr>
</table>
<hr style="display:none;">
<h3>
    お支払い方法
    <button id="updateCheckoutDetailsPayment" class="command" type="button">変更</button>
</h3>
<img src="/amzn/css/logo-pay.png" width="30" style="width:30px;"></img>&nbsp;&nbsp;<span id="paymentDescriptor"></span>

<hr>
お支払い金額: <!--{%$amount%}--> 円
<br>
<!--
<div>
    <button id="placeorder" class="ap_button" type="button">Place Order</button>
</div>
-->
	<div class="btn_area">
		<br>
		<button id="placeorder" class="submit_sys block confirm ap_button">購入する</button>
		<a href="/cart/confirm" class="back_sys block">戻る</a>
	</div>	

</div>
<!--{%*
<div class="wrap_contents sub">
<form name="form1" action="./complete" method="POST">
	<div>
		<h5>お届け先・お支払い方法の選択</h5>
		<input type="hidden" name="orderReferenceId" id="orderReferenceId" value="" />
		<input type="hidden" name="accessToken" id="accessToken" value="" />

		<div id="addressBookWidgetDiv" style="height:250px"></div>
		<div id="walletWidgetDiv" style="height:250px"></div>
	</div>

	<div class="btn_area">
		<br>
		<button class="submit_sys block confirm">購入する</button>
		<a href="" class="back_sys block" onclick="document.form1.action='./confirm';document.form1.submit();">戻る</a>
	</div>	

</from>
</div>
*%}-->

<!--{%*
<script type='text/javascript'>
	function getURLParameter(name, source) {
			return decodeURIComponent((new RegExp('[?|&amp;|#]' + name + '=' +
											'([^&;]+?)(&|#|;|$)').exec(source) || [, ""])[1].replace(/\+/g, '%20')) || null;
	}

	var error = getURLParameter("error", location.search);
	if (typeof error === 'string' && error.match(/^access_denied/)) {
		console.log('Amazonアカウントでのサインインをキャンセルされたため、戻る');
		window.location.href = '<!--{%$url_signin_cancel%}-->';
	}
</script>

<script type='text/javascript'>

let clientId = "<!--{%$client_id%}-->"; 
let sellerId = "<!--{%$merchant_id%}-->";


	// get access token
	function getURLParameter(name, source) {
		return decodeURIComponent((new RegExp('[?|&amp;|#]' + name + '=' +
									'([^&;]+?)(&|#|;|$)').exec(source) || [, ""])[1].replace(/\+/g, '%20')) || null;
	}
	//popup=trueにする場合
	var accessToken = getURLParameter("access_token", location.href);
	// popup=falseにする場合
	// var accessToken = getURLParameter("access_token", location.hash);
	// if (typeof accessToken === 'string' && accessToken.match(/^Atza/)) {
	//     document.cookie = "amazon_Login_accessToken=" + accessToken + ";path=/;secure";
	// }

	window.onAmazonLoginReady = function() {
		amazon.Login.setClientId(clientId);
		amazon.Login.setUseCookie(false); //popup=falseにときに必要

		if (accessToken) {
			document.getElementById("accessToken").value = accessToken;
		}
	};

	window.onAmazonPaymentsReady = function() {
		showAddressBookWidget();
	};

	function showAddressBookWidget() {
		// AddressBook
		new OffAmazonPayments.Widgets.AddressBook({
			sellerId: sellerId,

			onReady: function (orderReference) {
				var orderReferenceId = orderReference.getAmazonOrderReferenceId();

				document.getElementById("orderReferenceId").value = orderReferenceId;						
				// Wallet
				showWalletWidget(orderReferenceId);
			},
			onAddressSelect: function (orderReference) {    // 住所選択時
				// お届け先の住所が変更された時に呼び出されます、ここで手数料などの再計算ができます。
			},
			design: {
				designMode: 'responsive'
			},
			onError: function (error) {
				console.log('OffAmazonPayments.Widgets.AddressBook', error.getErrorCode(), error.getErrorMessage());
			}
		}).bind("addressBookWidgetDiv");
	}

	function showWalletWidget(orderReferenceId) {
		// Wallet
		new OffAmazonPayments.Widgets.Wallet({
			sellerId: sellerId,
			amazonOrderReferenceId: orderReferenceId,
			onReady: function(orderReference) {
				console.log(orderReference.getAmazonOrderReferenceId());
			},
			onPaymentSelect: function() {   // 支払方法選択
			},
			design: {
				designMode: 'responsive'
			},
			onError: function(error) {
				console.log('OffAmazonPayments.Widgets.Wallet', error.getErrorCode(), error.getErrorMessage());
			}
		}).bind("walletWidgetDiv");
	}

</script>

<script type="text/javascript" src="<!--{%$url_widget_js%}-->" async></script>

*%}-->

<!--{%include file='smarty/common/include/fbnr.tpl'%}-->
<!--{%include file='smarty/common/include/footer.tpl'%}-->
<script src="/amzn/js/uikit.min.js"></script>
<script src="/amzn/js/uikit-icons.min.js"></script>
<script src="https://static-fe.payments-amazon.com/checkout.js"></script>
<script src="/amzn/js/common.js"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function() {
    var checkout_session_id = getUrlParameter('amazonCheckoutSessionId');
    console.log('checkout_session_id:'+checkout_session_id);

    $.ajax({
        type: 'POST',
        url: '/ajax/checkout',
        data: {
            checkout_session_id: checkout_session_id
        },
    })
    .then(
        function(result) { //success
            var json = $.parseJSON(result).response;
            console.log(result);

            //$("#buyerName").html(json.buyer.name);
            $("#buyerEmail").html(json.buyer.email);
            $("#paymentDescriptor").html(json.paymentPreferences[0].paymentDescriptor);
            if(null != json.shippingAddress){
            $("#addressName").html(json.shippingAddress.name);
            $("#addressLine1").html(json.shippingAddress.addressLine1);
            $("#addressLine2").html(json.shippingAddress.addressLine2);
            $("#addressLine3").html(json.shippingAddress.addressLine3);
            $("#addressStageOrRegion").html(json.shippingAddress.stateOrRegion);
            $("#addressZipcode").html(json.shippingAddress.postalCode);
            $("#phoneNumber").html(json.shippingAddress.phoneNumber);
            }
            if(null != json.billingAddress){
            $("#ba_addressName").html(json.billingAddress.name);
            $("#ba_addressLine1").html(json.billingAddress.addressLine1);
            $("#ba_addressLine2").html(json.billingAddress.addressLine2);
            $("#ba_addressLine3").html(json.billingAddress.addressLine3);
            $("#ba_addressStageOrRegion").html(json.billingAddress.stateOrRegion);
            $("#ba_addressZipcode").html(json.billingAddress.postalCode);
            $("#ba_phoneNumber").html(json.billingAddress.phoneNumber);
            }
        },
        function() { //failure
            console.log("error");
        }
    );

    amazon.Pay.bindChangeAction('#updateCheckoutDetailsAddress', {
        amazonCheckoutSessionId: checkout_session_id,
        changeAction: 'changeAddress'
    });
    
    amazon.Pay.bindChangeAction('#updateCheckoutDetailsPayment', {
        amazonCheckoutSessionId: checkout_session_id,
        changeAction: 'changePayment'
    });

    $(document).on('click','#placeorder', function() {
        $.ajax({
            type: 'POST',
            url: '/ajax/updateCheckout',
            data: {
                checkout_session_id: checkout_session_id,
                amount: <!--{%$amount%}-->,
                order_id: <!--{%$order_id%}-->
            },
        })
        .then(
            function(result) { //success
                var json = $.parseJSON(result).response;
                console.log(result);

                if(json.webCheckoutDetails.amazonPayRedirectUrl != null) {
                    window.location.href = json.webCheckoutDetails.amazonPayRedirectUrl;
                }
            },
            function() { //failure
                console.log("error");
            }
        );
    });
});
</script>

