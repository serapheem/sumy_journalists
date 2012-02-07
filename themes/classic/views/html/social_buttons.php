<?php/** * File with social buttons */if ( !empty( $section ) && !empty( $item->id ) ){	$section = strtolower( $section );		$link = Yii::app( )		->createAbsoluteUrl( "/{$section}/" . $item->id );		$fb_attr = 'data-href="' . CHtml::encode( $link ) . '"';	$vk_attr = ', pageUrl: "' . CHtml::encode( $link ) . '"';	$go_attr = 'href="' . CHtml::encode( $link ) . '"';}else {	$fb_attr = '';	$vk_attr = '';	$go_attr = '';}?><div id="facebook_block" class="fleft">    <div class="fb-like" data-send="false" data-layout="button_count" data-width="180" data-show-faces="true" <?php echo $fb_attr ?>></div></div>
<div id="vkontakte_block" class="fleft"><div id="vk_like" class="fleft"></div></div>
<div id="google_block" class="fleft"><g:plusone <?php echo $go_attr ?>></g:plusone></div>
<div class="clear"></div>
<div id="fb-root"></div>
<script type="text/javascript">    window.onload = function ()     {        VK.Widgets.Like('vk_like', { type: 'button'<?php echo $vk_attr ?> });
        $('#vk_like').css('clear', '');
        (function(d, s, id) {          var js, fjs = d.getElementsByTagName(s)[0];          if (d.getElementById(id)) {return;}          js = d.createElement(s); js.id = id;          js.src = "//connect.facebook.net/uk_UA/all.js#xfbml=1&appId=116412811804627";          fjs.parentNode.insertBefore(js, fjs);        }(document, 'script', 'facebook-jssdk'));    }</script>
<script type="text/javascript" src="https://apis.google.com/js/plusone.js">    {lang: 'uk'}</script>
