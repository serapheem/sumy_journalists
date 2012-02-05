<?php
/**
 * The poll block
 */

?>


<h2><?php echo Yii::t( 'main', 'POLL' ) ?></h2>
<strong><?php echo CHtml::encode( $poll->title ) ?></strong>
<?php 
$add_vote = true;
$session = Yii::app( )->session->get( 'poll' );
if ( !empty( $session ) && in_array( $poll->id, $session ) )
{
	$add_vote = false;
}
if ( $add_vote )
{
	// Check IP for voted
	$param = array(
		'section' => 'Poll', 
		'item_id' => $poll->id,
		'ip' => $_SERVER['REMOTE_ADDR']
	);
	$voted = VotedIP::model( )
		->findByAttributes( $param );
	if ( !empty( $voted->ip ) )
	{
		$add_vote = false;
	}
}
?>
<div>
<?php if ( !$add_vote ) : ?>
    <?php 
    $total = 0;
    foreach ( $poll->items AS $item ) 
    {
        $total += $item->count;
    }
    
    foreach ( $poll->items AS $k => $item ) :
        $rate = round( ( $item->count * 100 / $total ), 2 ); 
    ?>
        <div class="vote"><?php echo CHtml::encode( $item->title ) . " - {$item->count} ({$rate}%)"; ?></div>
        <div class="imgvote">
            <img width="<?php echo $rate; ?>%" height="10" style="border:1px solid black" 
            	src="<?php echo Yii::app()->theme->baseUrl; ?>/images/poll<?php echo $k%4; ?>.gif" 
            />
        </div>
    <?php endforeach; ?>
        
    <strong><?php echo Yii::t( 'main', 'TOTAL_VOTES' ) ?>: <?php echo $total; ?></strong>
<?php else: ?>
    <form actions="" method="post">
        <ul>
            <?php foreach ( $poll->items as $k => $item ) : ?>
                <li>
                    <?php if ( $k == 0 ) $checked = 'checked="checked"'; else $checked = ''; ?>
                    <input type="radio" value="<?php echo $item->id; ?>" name="vote" 
                    	id="vote<?php echo $item->id; ?>" <?php echo $checked; ?> 
                    />
                    <label for="vote<?php echo $item->id; ?>"><?php echo CHtml::encode( $item->title ) ?></label>
                </li>
            <?php endforeach; ?>
        </ul>
        <input type="hidden" name="poll_id" value="<?php echo $poll->id; ?>" />
        <button onclick="addVote(); return false;"><?php echo Yii::t( 'main', 'VOTE' ) ?></button>
    </form>
<?php endif; ?>
</div>
