<?php if ( empty( $rows ) ): ?>
	<div><?php echo Yii::t( 'participants', 'NO_ITEMS' ) ?></div>
<?php else: ?>
	<?php 
    $total = 0;
    foreach ( $rows as $row ) 
    {
        $total += $row->rating;
    }
	?>
	<?php foreach ( $rows AS $k => $row ) : ?>
		<?php 
		if ( $total )
		{
			$rate = round( ( $row->rating * 100 / $total ), 2 );
		}
		else {
			$rate = 0;
		} 
		?>
	    <div class="vote-block">
            <div class="vote">
            	<a href="/<?php echo $view .'/'. $row->id; ?>">
            		<?php echo CHtml::encode( $row->title ) ?>
            	</a>
            	<?php echo " - {$row->rating} ({$rate}%)"; ?>
            </div>
            <div class="imgvote">
                <img width="<?php echo $rate; ?>%" height="10" 
                	style="border:1px solid black" 
                	src="<?php echo Yii::app()->theme->baseUrl; ?>/images/poll<?php echo $k%4; ?>.gif" 
                />
            </div>
	    </div>
	<?php endforeach; ?>
	<div class="vote-result"><?php echo Yii::t( 'main', 'TOTAL_VOTES' ) ?>: <?php echo $total; ?></div>
<?php endif; ?>