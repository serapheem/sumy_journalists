<?php$cs = Yii::app( )->getClientScript( );  $cs->registerCssFile( Yii::app( )->theme->baseUrl . '/css/redmond/jquery-ui-1.8.16.custom.css' );$cs->registerScriptFile( Yii::app( )->theme->baseUrl . '/js/jquery-ui-1.8.16.custom.min.js', CClientScript::POS_END );$cs->registerScript(    'comments',    'jQuery(function($)     {        $("#comments").tabs();		VK.Widgets.Comments("vk_comments", {limit: 10, width: "685", attach: "*", pageUrl: "'.htmlspecialchars( $link ).'"});    });',    CClientScript::POS_END);if ( $link ){	$fb_attr = 'data-href="' . htmlspecialchars( $link ) . '"';}else {	$fb_attr = '';}?><div id="comments">    <ul class="comments-navigation">        <li><a class="" href="#vkontakte-comments">ВКонтакте</a></li>        <li><a class="" href="#facebook-comments">Facebook</a></li>    </ul>	    <div id="vkontakte-comments">        <div id="vk_comments"></div>    </div>    <div id="facebook-comments">        <div class="fb-comments" data-num-posts="10" data-width="685" <?php echo $fb_attr ?>></div>    </div></div>