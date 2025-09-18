<ul class="level1">
<li<!--{%if $tpl_subno == 'index'%}--> class="on"<!--{%/if%}--> id="navi-product-index"><a href="/admin/product"><span>商品マスター</span></a></li>
<!--{%if $smarty.session.shop == 'forzastyleshop'%}-->
<li<!--{%if $tpl_subno == 'copy'%}--> class="on"<!--{%/if%}--> id="navi-product-index"><a href="/admin/product/copy"><span>商品マスター(COPY)</span></a></li>
<!--{%/if%}-->
<li<!--{%if $tpl_subno == 'product'%}--> class="on"<!--{%/if%}--> id="navi-product-product"><a href="/admin/product/upload"><span>商品登録</span></a></li>
<li<!--{%if $tpl_subno == 'productdel'%}--> class="on"<!--{%/if%}--> id="navi-product-productdel"><a href="/admin/product/uploaddel"><span>商品削除</span></a></li>
<li<!--{%if $tpl_subno == 'brand'%}--> class="on"<!--{%/if%}--> id="navi-product-product"><a href="/admin/product/brand"><span>ブランド登録</span></a></li>
<!--{%if $smarty.session.shop == 'brshop'%}-->
<li<!--{%if $tpl_subno == 'theme'%}--> class="on"<!--{%/if%}--> id="navi-product-product"><a href="/admin/product/theme"><span>テーマ登録</span></a></li>
<!--{%/if%}-->
</ul>
