<table cellspacing="25" cellpadding="5" border="0" class="contentTable">
    <tbody>
        <?php
        // Check IP for voted
		$param = array(
			'section' => 'Participants', 
			'ip' => $_SERVER['REMOTE_ADDR']
		);
		$voted = VotedIP::model( )
			->findByAttributes( $param );
		if ( empty( $voted->ip ) )
		{
			$can_change = true;
		}
		else {
			$can_change = false;
		}
        
        $item_in_line = 4;
        $counter = 1;
        foreach ( $rows AS $row ) :
			// Get image of item
			$image = Helper::getThumbImage( $row->body );
			$image = Yii::app( )->createAbsoluteUrl( empty( $image ) ? Yii::app()->theme->baseUrl . '/images/no_person_image.png' : $image );
            // Get link of item
            $link = Yii::app( )->createAbsoluteUrl( '/' . $view . '/' . $row->id . ( empty( $row->alias ) ? '' : ':' . $row->alias ) );
			?>
            <?php if ( ( ceil( ( $counter - 1 ) / $item_in_line ) == ( $counter - 1 ) / $item_in_line ) || ( $counter == 1 ) ) : ?>
                <tr class="sectiontableentry" >
            <?php endif; ?>
                <td valign="top" align="center">
                    <div class="personBox">
                        <div class="personImg"><a href="<?php echo $link ?>">
                            <img src="<?php echo $image; ?>" title="<?php echo CHtml::encode( $row->title ) ?>" />
                        </a></div>
                        
                        <div class="personTitle" >
                            <h4><a href="<?php echo $link ?>"><?php echo CHtml::encode( $row->title ) ?></a></h4>
                        </div>
                        
                        <?php 
						if ($row->top10): 
							if ( $can_change )
							{
								$session = Yii::app( )->session;
								$change_rating = $session->get( 'change_rating' );
								$show_change_rating = true;
								if ( isset( $change_rating['Participants'] ) && is_array( $change_rating['Participants'] ) ) 
								{
									$show_change_rating = !in_array( $row->id, $change_rating['Participants'] );
								}
							}
							else {
								$show_change_rating = false;
							}
							
							//S. hide change variant
							//$show_change_rating = false;
						?>
                        <div class="rating" id="rating-<?php echo $row->id ?>">
                        	<?php echo Yii::t( 'main', 'VOTES' ) ?>: <?php echo $row->rating ?>
                        	
                        	<?php if ( $show_change_rating ) : ?>
						        <div class="rating-up" onclick="addParticipantVote(<?php echo $row->id ?>, 'Participants');">
						        	<?php echo Yii::t( 'main', 'VOTE' ) ?>
						        </div>
						        <div class="ajax-loader"></div>
						        <div class="ajax-overlay"></div>
						    <?php endif; ?>
						    <div class="clear"></div>
						</div>
					    <?php endif; ?> 
                    </div>
                </td>
            <?php 
            if ( ceil( $counter / $item_in_line ) == $counter / $item_in_line )
			{
                echo "</tr>";
			} 
            $counter++; 
        endforeach; 
        ?>
    </tbody>
</table>
<div id="bottom-links">
	<div id="show-all" class="fleft">
		<a href="<?php Yii::app( )->request->baseUrl ?>/participants.html"><?php echo Yii::t( 'main', 'SHOW_ALL' ) ?></a>
	</div>
	<div id="results" class="fleft">
		<a href="<?php Yii::app( )->request->baseUrl ?>/top10/results.html"><?php echo Yii::t( 'main', 'RESULTS' ) ?></a>
	</div>
	<div class="clear"></div>
</div>
