<?php/** * File with comments block */if ( !empty( $section ) && !empty( $item->id ) ){	$link = Yii::app( )		->createAbsoluteUrl( '/' . strtolower( $section ) . '/' . $item->id );		$fb_attr = 'data-href="' . CHtml::encode( $link ) . '"';	$vk_attr = ', pageUrl: "' . CHtml::encode( $link ) . '"';}else {	$fb_attr = '';	$vk_attr = 'data-href="' . CHtml::encode( $link ) . '"';}$cs = Yii::app( )->getClientScript( );  $cs->registerCssFile( Yii::app( )->theme->baseUrl . '/css/smoothness/jquery-ui-1.8.17.custom.css' );$cs->registerScriptFile( Yii::app( )->theme->baseUrl . '/js/jquery-ui-1.8.16.custom.min.js', CClientScript::POS_END );$cs->registerScript(    'comments',    'function saveCommentsCount(num, last_comment, date, sign) 	{		$.post( "/ajax/saveCommentsNumber", {			type: "vkontakte",			section: "' . $section . '",			id: "' . $item->id . '",			num: num,			last_comment: last_comment,			date: date,			sign: sign		})	}    jQuery(function($)     {        $("#comments").tabs();		VK.Widgets.Comments("vk_comments", { width: "685", limit: 10, onChange: saveCommentsCount' . $vk_attr . ' });		/*		FB.Event.subscribe("comment.create", function(response) 		{			console.log(response)		});		FB.Event.subscribe("comment.remove", function(response) 		{			console.log(response)		});		*/    });',    CClientScript::POS_END);?><div id="comments">    <ul class="comments-navigation">        <li><a class="" href="#vkontakte-comments">ВКонтакте</a></li>        <li><a class="" href="#facebook-comments">Facebook</a></li>    </ul>	    <div id="vkontakte-comments">        <div id="vk_comments"></div>    </div>    <div id="facebook-comments">        <div class="fb-comments" data-num-posts="10" data-width="685" <?php echo $fb_attr ?>></div>    </div></div>