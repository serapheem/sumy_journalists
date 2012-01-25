<?php 
$link = '/participant/' . $record->id;
$link = Yii::app( )
	->createAbsoluteUrl( $link );
?>
<div id="contentText">
    <h1><?php echo $record->title; ?></h1>
    <span class="note">Опубліковано: <?php echo CLocale::getInstance('uk')->dateFormatter->formatDateTime($record->created, 'long', null); ?></span>
    <br />
    <br />
    <div><?php echo $record->body; ?></div>
</div>
<div id="contentFoot">
	<?php 
	if ($record->top10): 
		$session = Yii::app()->session;
        $change_rating = $session->get('change_rating');
        $show_change_rating = true;
        if ( is_array($change_rating['Participants']) ) 
		{
            $show_change_rating = !in_array( $record->id, $change_rating['Participants'] );
        }
		
		if ( $show_change_rating )
		{
			// Check IP for voted
			$param = array(
						'section' => 'Participants', 
						'ip' => $_SERVER['REMOTE_ADDR']
					);
			$voted = VotedIP::model()->findByAttributes( $param );
			if ( !empty($voted->ip) )
			{
				$show_change_rating = false;
			}
		}
		
		//S. hide change variant
		//$show_change_rating = false;
	?>
    <div class="rating note" id="rating-<?php echo $record->id ?>" style="text-align: center">
    	Голосів: <?php echo $record->rating ?>
    	
    	<?php if ($show_change_rating): ?>
	        <div class="rating-up" onclick="addParticipantVote(<?php echo $record->id ?>, 'Participants');">
	        	Проголосувати
	        </div>
	        <div class="ajax-loader"></div>
			<div class="ajax-overlay"></div>
	    <?php endif; ?>
		<div class="clear"></div>
	</div>
	<?php endif; ?> 
    
    <?php echo Helper::getSocialButtons( $link ) ?>
</div>
<?php echo Helper::getCommentsBlock( $link ) ?>
