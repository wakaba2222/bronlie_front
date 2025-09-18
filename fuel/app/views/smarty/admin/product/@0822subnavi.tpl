<!--{*
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2011 LOCKON CO.,LTD. All Rights Reserved.
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
 */
*}-->
<ul class="level1">
<li<!--{if $tpl_subno == 'index'}--> class="on"<!--{/if}--> id="navi-products-index"><a href="<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->products/<!--{$smarty.const.DIR_INDEX_PATH}-->"><span>商品マスター</span></a></li>
<li<!--{if $tpl_subno == 'product'}--> class="on"<!--{/if}--> id="navi-products-product"><a href="<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->products/product.php"><span>商品登録</span></a></li>
<!--{if $shop_mode == 'guji' || $shop_mode == 'ring'}-->
<li<!--{if $tpl_subno == 'upload_create_csv'}--> class="on"<!--{/if}--> id="navi-products-uploadcreatecsv"><a href="<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->products/upload_create_csv.php"><span>商品登録CSV作成</span></a></li>
<!--{/if}-->
<li<!--{if $tpl_subno == 'upload_csv'}--> class="on"<!--{/if}--> id="navi-products-uploadcsv"><a href="<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->products/upload_csv.php"><span>商品登録CSV</span></a></li>
<!--{*
<!--{if $smarty.const.OPTION_CLASS_REGIST == 1}-->
<li<!--{if $tpl_subno == 'class'}--> class="on"<!--{/if}--> id="navi-products-class"><a href="<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->products/class.php"><span>規格管理</span></a></li>
<!--{/if}-->
*}-->
<!--{*## 追加規格 ADD BEGIN ##*}-->
<!--{if $smarty.const.USE_EXTRA_CLASS == 1}-->
<li<!--{if $tpl_subno == 'extra_class'}--> class="on"<!--{/if}--> id="navi-products-extra-class"><a href="<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->products/extra_class.php"><span>コードマスタ管理</span></a></li>
<!--{/if}-->
<!--{*## 追加規格 ADD END ##*}-->
<li<!--{if $tpl_subno == 'category'}--> class="on"<!--{/if}--> id="navi-products-category"><a href="<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->products/category.php"><span>部門ー登録</span></a></li>
<!--{*
<li<!--{if $tpl_subno == 'upload_csv_category'}--> class="on"<!--{/if}--> id="navi-products-upload-csv-category"><a href="<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->products/upload_csv_category.php"><span>部門ー登録CSV</span></a></li>
<li<!--{if $tpl_subno == 'maker'}--> class="on"<!--{/if}--> id="navi-products-maker"><a href="<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->products/maker.php"><span>メーカー登録</span></a></li>
<li<!--{if $tpl_subno == 'product_rank'}--> class="on"<!--{/if}--> id="navi-products-rank"><a href="<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->products/product_rank.php"><span>商品並び替え</span></a></li>
<li<!--{if $tpl_subno == 'review'}--> class="on"<!--{/if}--> id="navi-products-review"><a href="<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->products/review.php"><span>レビュー管理</span></a></li>
*}-->
<!--{if $shop_mode != '' || $smarty.session.shop_admin == 'on'}-->
<li<!--{if $tpl_subno == 'squeezing'}--> class="on"<!--{/if}--> id="navi-products-squeezing"><a href="<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->products/squeezing.php?mode=category"><span>部門絞り込み登録</span></a></li>
<li<!--{if $tpl_subno == 'squeezing'}--> class="on"<!--{/if}--> id="navi-products-squeezing"><a href="<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->products/squeezing.php?mode=size"><span>サイズ絞り込み登録</span></a></li>
<li<!--{if $tpl_subno == 'squeezing'}--> class="on"<!--{/if}--> id="navi-products-squeezing"><a href="<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->products/squeezing.php?mode=color"><span>カラー絞り込み登録</span></a></li>
<li<!--{if $tpl_subno == 'squeezing'}--> class="on"<!--{/if}--> id="navi-products-squeezing"><a href="<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->products/squeezing.php?mode=brand"><span>ブランド絞り込み登録</span></a></li>
<!--{/if}-->
</ul>
