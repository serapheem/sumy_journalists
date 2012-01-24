<table cellspacing="25" cellpadding="5" border="0" class="contentTable">
    <tbody>
        <?php
        $item_in_line = 1;
        $counter = 1;
        foreach ($rows as $row):
            ?>
            <?php 
            if (ceil(($counter - 1) / $item_in_line) == ($counter - 1) / $item_in_line or $counter == 1) { ?>
                <tr class="sectiontableentry" >
            <?php } ?>
                <td valign="top" align="center">
                    <div class="articlesBox">
                        <div class="articlesImg"><a href="/<?php echo $view .'/'. $row->id; ?>">
                            <?php 
                            $image = Helper::getThumbImage($row->body);
                                
                            if (empty($image)) 
                            {
                                $image = Yii::app()->theme->baseUrl . '/images/no_image_small.png';
                            }
                            ?>
                            <img src="<?php echo $image; ?>" title="<?php echo $row->title; ?>" />
                        </a></div>
                        <div class="articlesText" >
                            <h4><a href="/<?php echo $view .'/'. $row->id; ?>"><?php echo $row->title; ?></a></h4>
                            <div>
                                <p style="font-size:10px;"><?php //echo $row->date; ?></p>
                                <p><?php 
                                    $body = strip_tags($row->body);
                                    $body = wordwrap($body, 300, '`|+');
                                    $wrap_pos = strpos($body, '`|+');
                                    if ($wrap_pos !== false) {
                                        echo substr($body, 0, $wrap_pos).'...';
                                    } else {
                                        echo $body;
                                    } 
                                ?></p>
                                <a href="/<?php echo $view .'/'. $row->id; ?>" class="readMore">читати далі...</a>
                            </div>
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

