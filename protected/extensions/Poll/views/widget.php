<?php
/**
 * Layout file for Poll Widget
 */

if ( $show_poll && $add_vote ) {
	Yii::app()->getClientScript()->registerScript( 'poll', 
		'function addVote()  {
			var poll_id = $("#poll input[name=poll_id]").val();
			var item_id = $(\'#poll input[name="vote"]:checked\').val(); 
			
			$.getJSON( "/ajax/addvoite", { "poll_id": poll_id, "item_id": item_id }, 
				function(data)  {
					if ( !data["error"] ) {
						$("#poll").fadeOut(500, function() {
							
							$(this).html(data["html"]);
							$(this).fadeIn(500)
						})
					}
				}
			);
		}',
		CClientScript::POS_END
	);
}
?>

<?php if ( $show_poll ) : ?>
	<h2><?php echo Yii::t( 'main', 'POLL' ) ?></h2>
	<strong><?php echo CHtml::encode( $poll->title ) ?></strong>
	<div>
	<?php if ( !$add_vote ) : ?>
		<?php foreach ( $poll->items as $k => $item ) : ?>
			<?php $rate = round( ( $item->count * 100 / $total ), 2 ); ?>
			<div class="vote"><?php echo CHtml::encode( $item->title ) . " - {$item->count} ({$rate}%)"; ?></div>
			<div class="imgvote">
				<img width="<?php echo $rate; ?>%" height="10" style="border:1px solid black" 
					src="<?php echo $assets_path; ?>/images/poll<?php echo $k%4; ?>.gif" 
				/>
			</div>
		<?php endforeach; ?>
		
		<strong><?php echo Yii::t( 'main', 'TOTAL_VOTES' ) ?>: <?php echo $total; ?></strong>
	<?php else: ?>
		<form actions="#" method="post">
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
			<button onclick="addVote(); return false;"><?php echo Yii::t( 'main', 'VOTE' ); ?></button>
		</form>
	<?php endif; ?>
	</div>
<?php endif; ?>
