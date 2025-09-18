<!--{*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2012 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *}-->

[注文番号] <!--{$registData.order_id}-->
[注文日時] <!--{$registData.order_date}-->
[支払方法] BR支払
[配送方法] BR配送

[備考]

[ご注文者]
BR (BR) 様
〒000-0000
住所
TEL : 000-0000-0000
MAIL : br@com
端末 : PC

[お届け先]
BR (BR) 様
〒000-0000
住所
TEL : 000-0000-0000

[お買い上げ明細]
<!--{section name=cnt loop=$registData.arrProduct}-->
[商品]
<!--{$registData.arrProduct[cnt].product_name}--> (<!--{$registData.arrProduct[cnt].product_code}-->)
サイズ : <!--{$registData.arrProduct[cnt].size}-->
カラー : <!--{$registData.arrProduct[cnt].color}-->
価格 <!--{$registData.arrProduct[cnt].price|number_format|default:0}-->(円) x <!--{$registData.arrProduct[cnt].quantity}-->(個) = <!--{$registData.arrProduct[cnt].price*$registData.arrProduct[cnt].quantity|number_format|default:0}-->(円) (税別)

<!--{/section}-->

**************************************************
小計 : <!--{$registData.subtotal|number_format|default:0}-->(円)
消費税 : <!--{$registData.tax|number_format|default:0}-->(円)
送料 : 0(円)
ラッピング料 : 0(円)
ポイント利用 : 0(円)
-------------------------
合計 : <!--{$registData.total|number_format|default:0}-->(円)


--------------------------------------------------
