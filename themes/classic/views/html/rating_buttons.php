<?php
/**
 * File with rating buttons
 */
?>

<div id="rating" class="note fleft">
    <?php
    $session = Yii::app( )->session;
    $change_rating = $session->get( 'change_rating' );
    $show_change_rating = true;
    if ( isset( $change_rating[$section] ) && is_array( $change_rating[$section] ) ) 
    {
        $show_change_rating = !in_array($item->id, $change_rating[$section]);
    }

    if ( $show_change_rating )
    {
        // Check IP for voted
        $param = array(
            'section' => $section, 
            'item_id' => $item->id,
            'ip' => $_SERVER['REMOTE_ADDR']
        );
        $voted = VotedIP::model( )
        	->findByAttributes( $param );
        if ( !empty( $voted->ip ) )
        {
            $show_change_rating = false;
        }
    }

    if ( $show_change_rating ) :
    ?>
        <div id="rating-down" onclick="ratingChange(<?php echo $item->id; ?>, '<?php echo $section ?>', '-1');"></div>
    <?php
    endif;

    $class = '';
    if ( !$show_change_rating ) 
    {
        $class = 'no-change';
    }

    if ( $item->rating > 0 ) 
    {
        $class .= ' positive';
    } 
    elseif ( $item->rating < 0 ) 
    {
        $class .= ' negative';
    }
    ?>

    <div id="current-rating" class="<?php echo $class; ?>"><?php echo $item->rating; ?></div>
    <?php if ( $show_change_rating ) : ?>
        <div id="rating-up" onclick="ratingChange(<?php echo $item->id; ?>, '<?php echo $section ?>', '1');"></div>
    <?php endif; ?>

    <div class="clear"></div>
</div>