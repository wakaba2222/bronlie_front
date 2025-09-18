
<!--{%*$arrOrder.order_company*%}-->
<!--{%*<!--{%$arrOrder.name01%}--> <!--{%$arrOrder.name02%}--> 様*%}-->

<!--{%$tpl_header%}-->

<!--{%$arrForm['mail_header']|h%}-->

<!--{%$arrForm['mail_body']|h%}-->

<!--{%if $arrForm['flg_order'] %}-->
<!--{%include file='smarty/email/order_mail.tpl'%}-->
<!--{%/if%}-->

<!--{%$arrForm['mail_footer']|h%}-->

<!--{%$tpl_footer%}-->
