<table cellspacing="25" cellpadding="5" border="0" class="contentTable">
    <tbody>
        <?php
        $item_in_line = 4;
        $counter = 1;
        foreach ( $rows as $row ):
			// Get image of article
            $image = Helper::getThumbImage( $row->body );
            $image = Yii::app( )->createAbsoluteUrl( empty( $image ) ? Yii::app()->theme->baseUrl . '/images/no_person_image.png' : $image );
            // Get link of article
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

