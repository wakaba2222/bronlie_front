
<!--{%*$arrOrder.order_company*%}-->
<!--{%*<!--{%$arrOrder.name01%}--> <!--{%$arrOrder.name02%}--> 様*%}-->

<!--{%$tpl_header%}-->

************************************************
　ご請求金額
************************************************

ご注文番号：<!--{%$arrOrder.order_id%}-->
お支払合計：￥ <!--{%$arrOrder.payment_total|number_format|default:0%}-->
ご決済方法：<!--{%$arrPayment[$arrOrder.payment_id]%}-->
メッセージ：<!--{%$arrOrder.memo%}-->

************************************************
　ご注文商品明細
************************************************

<!--{%section name=cnt loop=$arrOrderDetail%}-->
商品コード: <!--{%$arrOrderDetail[cnt].product_code%}-->
ショップ名：[<!--{%$arrOrderDetail[cnt].shop_name%}-->]
商品名: [<!--{%$arrOrderDetail[cnt].brand%}-->]<!--{%$arrOrderDetail[cnt].product_name|strip_tags%}-->
<!--{%if $arrOrderDetail[cnt].product_url_id%}-->
商品URL：<!--{%$arrOrderDetail[cnt].product_url_id%}-->
<!--{%/if%}-->

[<!--{%$arrOrderDetail[cnt].color_name%}--> / <!--{%$arrOrderDetail[cnt].size_name%}-->]
<!--{%*
<!--{%if $arrOrderDetail[cnt].gara%}-->
[<!--{%$arrOrderDetail[cnt].gara%}--> / <!--{%$arrOrderDetail[cnt].color_name%}--> / <!--{%$arrOrderDetail[cnt].size_name%}-->]
<!--{%else%}-->
[<!--{%$arrOrderDetail[cnt].color_name%}--> / <!--{%$arrOrderDetail[cnt].size_name%}-->]
<!--{%/if%}-->
*%}-->
単価：￥ <!--{%$arrOrderDetail[cnt].price|number_format%}-->
数量：<!--{%$arrOrderDetail[cnt].quantity%}-->

<!--{%/section%}-->
-------------------------------------------------
小　計 ￥ <!--{%($arrOrder.total+$arrOrder.tax)|number_format|default:0%}--> (うち消費税 ￥<!--{%$arrOrder.tax|number_format|default:0%}-->）
値引き ￥ <!--{%$arrOrder.discount|number_format|default:0%}-->
送　料 ￥ <!--{%Tag_Util::taxin_cal($arrOrder.deliv_fee)|number_format|default:0%}-->
手数料 ￥ <!--{%$arrOrder.fee|number_format|default:0%}-->
<!--{%if $arrOrder.gift_price%}-->
ギフトラッピング　「<!--{%if $arrOrder.gift%}-->あり<!--{%else%}-->なし<!--{%/if%}-->」　￥ <!--{%$arrOrder.gift_price|number_format|default:0%}-->
<!--{%/if%}-->
============================================
合　計 ￥ <!--{%($arrOrder.payment_total)|number_format|default:0%}-->

************************************************
　配送情報
************************************************

<!--{%foreach item=shipping name=shipping from=$arrDeliv%}-->
◎お届け先<!--{%if count($arrDeliv) > 1%}--><!--{%$smarty.foreach.shipping.iteration%}--><!--{%/if%}-->
法人名・団体名：<!--{%$shipping.company%}-->
　お名前　：<!--{%$shipping.name01%}--> <!--{%$shipping.name02%}-->　様
　郵便番号：〒<!--{%$shipping.zip01%}-->-<!--{%$shipping.zip02%}-->
　住所　　：<!--{%$arrPref[$shipping.pref]%}--><!--{%$shipping.addr01%}--><!--{%$shipping.addr02%}-->
　電話番号：<!--{%$shipping.tel01%}-->

　お届け日：<!--{%$arrOrder.deliv_date|date_format:"%Y/%m/%d"|default:"指定なし"%}-->
　お届け時間：<!--{%$arrOrder.deliv_time|default:"指定なし"%}-->

<!--{%/foreach%}-->

============================================
明細書　　　　　　「<!--{%if $arrOrder.detail_statement%}-->あり<!--{%else%}-->なし<!--{%/if%}-->」
領収書宛名　　　　「<!--{%$arrOrder.recepit_atena%}-->」
領収書但し　　　　「<!--{%$arrOrder.receipt_tadashi%}-->」
簡易包装　　　　　「<!--{%if $arrOrder.packing%}-->あり<!--{%else%}-->なし<!--{%/if%}-->」
メッセージカード　「<!--{%if $arrOrder.card%}-->カードあり<!--{%else%}-->カードなし<!--{%/if%}-->」
ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
メッセージ内容
---
<!--{%$arrOrder.msg_card%}-->
ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

<!--{%if false%}-->
<!--{%if $arrOrder.customer_id && $smarty.const.USE_POINT !== false%}-->
============================================
<!--{%* ご注文前のポイント {$tpl_user_point} pt *%}-->
ご使用ポイント <!--{%$arrOrder.use_point|default:0|number_format%}--> pt
加算される予定の仮ポイント <!--{%$arrOrder.add_point|default:0|number_format%}--> pt
現在の使用可能な有効ポイント <!--{%$arrCustomer.point|default:0|number_format%}--> pt
ポイントについて：<!--{%$smarty.const.HTTP_URL%}-->shoppingguide/point.php
<!--{%/if%}-->
<!--{%/if%}-->
<!--{%$tpl_footer%}-->
