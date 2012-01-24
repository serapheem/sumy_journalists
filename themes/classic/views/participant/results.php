<?php if ( empty($rows) ): ?>
	<div>Немає жодного учасника.</div>
<?php else: ?>
	<?php 
    $total = 0;
    foreach ($rows as $row) 
    {
        $total += $row->rating;
    }
	?>
	<?php foreach ($rows as $k => $row): ?>
		<?php $rate = round( ($row->rating * 100 / $total), 2); ?>
	    <div class="vote-block">
            <div class="vote">
            	<a href="/<?php echo $view .'/'. $row->id; ?>">
            		<?php echo "{$row->title}"; ?>
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
	<?php endforeach ?>
	<strong>Всього проголосувало: <?php echo $total; ?></strong>
<?php endif ?>