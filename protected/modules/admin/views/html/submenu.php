<ul class="tabs">
	<a href="/admin/news/" class="a_in_tab"><span>
		<li <?php if ( $view == 'news' ) echo 'class="current"'; ?>><?php echo Yii::t( 'news', 'SECTION_NAME' ) ?></li>
	</span></a>
	<a href="/admin/citystyle/" class="a_in_tab"><span>
		<li <?php if ( $view == 'citystyle' ) echo 'class="current"'; ?>><?php echo Yii::t( 'citystyle', 'SECTION_NAME' ) ?></li>
	</span></a>
	<a href="/admin/knowour/" class="a_in_tab"><span>
		<li <?php if ( $view == 'knowour' ) echo 'class="current"'; ?>><?php echo Yii::t( 'knowour', 'SECTION_NAME' ) ?>х</li>
	</span></a>
	<a href="/admin/tyca/" class="a_in_tab"><span>
		<li <?php if ( $view == 'tyca' ) echo 'class="current"'; ?>><?php echo Yii::t( 'tyca', 'SECTION_NAME' ) ?></li>
	</span></a>
	<a href="/admin/participants/" class="a_in_tab"><span>
		<li <?php if ( $view == 'participants' ) echo 'class="current"'; ?>><?php echo Yii::t( 'participants', 'SECTION_NAME' ) ?></li>
	</span></a>
</ul>
