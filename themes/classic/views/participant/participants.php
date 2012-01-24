<table cellspacing="25" cellpadding="5" border="0" class="contentTable">
    <tbody>
        <?php
        $item_in_line = 4;
        $counter = 1;
        foreach ($rows as $row):
            ?>
            <?php 
            if (ceil(($counter - 1) / $item_in_line) == ($counter - 1) / $item_in_line or $counter == 1) { ?>
                <tr class="sectiontableentry" >
            <?php } ?>
                <td valign="top" align="center">
                    <div class="personBox">
                        <div class="personImg"><a href="/<?php echo $view .'/'. $row->id; ?>">
                            <?php 
                            $image = Helper::getThumbImage($row->body);
                                
                            if (empty ($image)) 
                            {
                                $image = Yii::app()->theme->baseUrl . '/images/no_person_image.png';
                            }
                            ?>
                            <img src="<?php echo $image; ?>" title="<?php echo $row->title; ?>" />
                        </a></div>
                        <div class="personTitle" >
                            <h4><a href="/<?php echo $view .'/'. $row->id; ?>"><?php echo $row->title; ?></a></h4>
                        </div>
                    </div>
                </td>
            <?php 
            if (ceil($counter / $item_in_line) == $counter / $item_in_line)
                echo "</tr>"; 
            $counter++; 
        endforeach; 
        ?>
    </tbody>
</table>

