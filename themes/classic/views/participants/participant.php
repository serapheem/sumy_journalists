<?php 
/**
 * Participant article layout
 */

$created = CLocale::getInstance( 'uk' )->dateFormatter->formatDateTime( $record->created, 'long', null );
?>

<div class="article-title">
	<?php echo CHtml::encode( $record->title ); ?>
</div>
<div class="article-info">
	<div class="note"><?php echo Yii::t( 'main', 'PUBLISHED' ); ?>: <?php echo $created; ?></div>
    <div class="note"><?php echo Yii::t( 'main', 'VIEWS' ); ?>: <?php echo $record->views; ?></div>
    <div class="clear"></div>
</div>
<div class="article-text">
    <?php echo $record->body; ?>
</div>
<div class="article-footer">
	<?php 
	if ($record->top10): 
		$session = Yii::app( )->session;
        $change_rating = $session->get( 'change_rating' );
        $show_change_rating = true;
        if ( isset( $change_rating['Participants'] ) && is_array( $change_rating['Participants'] ) ) 
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
			$voted = VotedIP::model( )
				->findByAttributes( $param );
			if ( !empty( $voted->ip ) )
			{
				$show_change_rating = false;
			}
		}
		
		//S. hide change variant
		//$show_change_rating = false;
	?>
    <div class="rating" id="rating-<?php echo $record->id ?>">
    	<?php echo Yii::t( 'main', 'VOTES' ) ?>: <?php echo $record->rating ?>
    	
    	<?php if ( $show_change_rating ): ?>
	        <div class="rating-up" onclick="addParticipantVote(<?php echo $record->id ?>, 'Participants');">
	        	<?php echo Yii::t( 'main', 'VOTE' ) ?>
	        </div>
	        <div class="ajax-loader"></div>
			<div class="ajax-overlay"></div>
	    <?php endif; ?>
		<div class="clear"></div>
	</div>
	<?php endif; ?> 
    
    <?php echo Helper::getSocialButtons( 'Participants', $record ) ?>
    
    <div class="clear"></div>
</div>
<?php $this->widget( 'application.extensions.SocialComments.SocialCommentsWidget', array( 'section' => 'Participants', 'item' => $record ) ); ?>
