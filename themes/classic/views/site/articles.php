<table cellspacing="25" cellpadding="5" border="0" class="contentTable">
	<tbody>
		<?php
		$item_in_line = 1;
		$counter = 1;
		foreach ( $rows as $row ):
			// Get image of article
			$image = Helper::getThumbImage( $row->body );
			$image = Yii::app( )->createAbsoluteUrl( empty( $image ) ? Yii::app()->theme->baseUrl . '/images/no_image_small.png' : $image );
			// Get link of article
			$link = Yii::app( )->createAbsoluteUrl( '/' . $view . '/' . $row->id . ( empty( $row->alias ) ? '' : ':' . $row->alias ) );
			// Get body of article
			$body = strip_tags( $row->body );
			$body = wordwrap( $body, 300, '`|+' );
			$wrap_pos = strpos( $body, '`|+' );
			if ( $wrap_pos !== false ) 
			{
				$body = substr( $body, 0, $wrap_pos ).'...';
			} 
		?>
			<?php if ( ( ceil( ( $counter - 1 ) / $item_in_line ) == ( $counter - 1 ) / $item_in_line ) || ( $counter == 1 ) ) : ?> 
				<tr class="sectiontableentry" >
			<?php endif; ?>
				<td valign="top" align="center">
					<div class="articlesBox">
						<div class="articlesImg"><a href="<?php echo $link ?>">
							<img src="<?php echo $image; ?>" title="<?php echo CHtml::encode( $row->title ) ?>" />
						</a></div>
						<div class="articlesText" >
							<h4><a href="<?php echo $link ?>"><?php echo CHtml::encode( $row->title ) ?></a></h4>
							<div>
								<p style="font-size:10px;"><?php //echo $row->date; ?></p>
								<p><?php echo $body ?></p>
								<a href="<?php echo $link ?>" class="readMore"><?php echo Yii::t( 'main', 'READ_MORE' ) ?>...</a>
							</div>
						</div>
						<div class="clear"></div>
					</div>
				</td>
			<?php 
			if ( ceil( $counter / $item_in_line ) == ( $counter / $item_in_line ) )
			{
				echo "</tr>";
			} 
			$counter++; 
		endforeach; 
		?>
	</tbody>
</table>

