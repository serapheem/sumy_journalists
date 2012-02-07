<ul class="tabs">
	<li <?php if ( $view == 'news' ) echo 'class="current"'; ?>>
		<a href="/admin/news/" class="a_in_tab">
			<?php echo Yii::t( 'news', 'SECTION_NAME' ) ?>
		</a>
	</li>
	<li <?php if ( $view == 'citystyle' ) echo 'class="current"'; ?>>
		<a href="/admin/citystyle/" class="a_in_tab">
			<?php echo Yii::t( 'citystyle', 'SECTION_NAME' ) ?>
		</a>
	</li>
	<li <?php if ( $view == 'knowour' ) echo 'class="current"'; ?>>
		<a href="/admin/knowour/" class="a_in_tab">
			<?php echo Yii::t( 'knowour', 'SECTION_NAME' ) ?>
		</a>
	</li>
	<li <?php if ( $view == 'tyca' ) echo 'class="current"'; ?>>
		<a href="/admin/tyca/" class="a_in_tab">
			<?php echo Yii::t( 'tyca', 'SECTION_NAME' ) ?>
		</a>
	</li>
	<li <?php if ( $view == 'participants' ) echo 'class="current"'; ?>>
		<a href="/admin/participants/" class="a_in_tab">
			<?php echo Yii::t( 'participants', 'SECTION_NAME' ) ?>
		</a>
	</li>
</ul>
