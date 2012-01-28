<?php
// in your view where you want to include JavaScripts
$cs = Yii::app( )->getClientScript( );  
$cs->registerScript(
	'front-column',
	'jQuery(document).ready(function($)
	{
		$("#frontLeft .front-column:first").css("padding-left", "0");
		$("#frontLeft .front-column:last").css("border", "none").css("padding-right", "0");
		$(".front-column").each(function(item)
		{
			if ($(this).children())
			{
				$(this).children().last().css("border", "none")
			}	
		})
	})',
	CClientScript::POS_END
);
?>
<div id="frontLeft">
    <?php if ( !empty( $news ) ): ?>
    <div id="main-block">
        <div class="frontImg">
            <?php 
            // Get main image of news
            $image = '';
            $pattern = '/(img|src)=("|\')[^"\'>]+/i'; 
            preg_match( $pattern, $news[0]->body, $media );

            $pattern = '/(img|src)("|\'|="|=\')(.*)/i'; 
            $url = preg_replace( $pattern, "$3", $media[0] );

            $info = pathinfo( $url );
            if ( isset( $info['extension'] ) ) 
            {
                if ( ( $info['extension'] == 'jpg' ) ||
                    ( $info['extension'] == 'jpeg' ) ||
                    ( $info['extension'] == 'gif' ) ||
                    ( $info['extension'] == 'png' ) ) 
                {
                    $image = $url;
                }
            }
            if ( empty( $image ) ) 
            {
                $image = '/images/no_image_big.png';
            }
			$image = Yii::app( )
				->createAbsoluteUrl( $image );
			// Get link of article
			if ( empty( $news[0]->alias ) )
			{
				$link = '/' . strtolower( $news[0]->section ) . '/' . $news[0]->id;
			}
			else {
				$link = '/' . strtolower( $news[0]->section ) . '/' . $news[0]->id . ':' . $news[0]->alias;
			}
			$link = Yii::app()
				->createAbsoluteUrl( $link );
			// Get created date
			$date = CLocale::getInstance( 'uk' )
				->dateFormatter
				->formatDateTime( $news[0]->created, 'long', null );
			// Get body of article
			$body = strip_tags( $news[0]->body );
            $body = wordwrap( $body, 300, '`|+' );
            $wrap_pos = strpos( $body, '`|+' );
            if ( $wrap_pos !== false ) 
            {
                $body = substr( $body, 0, $wrap_pos ) . '...';
            } 
            ?>
            <img src="<?php echo $image; ?>" title="<?php echo CHtml::encode( $news[0]->title ) ?>" />
        </div>
        <h3><a href="<?php echo $link ?>"><?php echo CHtml::encode( $news[0]->title ) ?></a></h3>
        <div>
            <p style="font-size:10px;"><?php echo $date ?></p>
            <p><?php echo $body ?></p>
            <a href="<?php echo $link ?>" class="readMore fright">читати далі...</a>
            <div class="clear"></div>
        </div>
    </div>
    <?php
    	unset( $news[0] );
		if ( count( $news ) > 4 )
		{
			$item_in_col = round( (count( $news ) - 3) / 3);
			$col1_news = array_slice( $news, 0, $item_in_col );
			$col2_news = array_slice( $news, $item_in_col, $item_in_col );
			$col3_news = array_slice( $news, $item_in_col * 2 );
			
			$show_column = true;
		} 
		else {
			$col3_news = $news;
			$show_column = false;
		}
    ?>
	    <?php if ( $show_column ) : ?>
	    <div class="front-column">
	    	<?php
		    if ( !empty( $col1_news ) ) :
		        foreach ( $col1_news AS $news_ ) :
					// Get link of article
					if ( empty( $news_->alias ) )
					{
						$link = '/' . strtolower( $news_->section ) . '/' . $news_->id;
					}
					else {
						$link = '/' . strtolower( $news_->section ) . '/' . $news_->id . ':' . $news_->alias;
					}
					$link = Yii::app( )
						->createAbsoluteUrl( $link );
					// Get image of article
					$image = Helper::getThumbImage( $news_->body );
                    if ( empty( $image ) ) 
                    {
                        $image = '/images/no_image.png';
                    }
					$image = Yii::app( )
						->createAbsoluteUrl( $image );
		    ?>
	            <div class="frontItem">
	                <div class="small-image">
	                	<a href="<?php echo $link ?>">
	                    	<img src="<?php echo $image; ?>" title="<?php echo CHtml::encode( $news_->title ) ?>" />
	                	</a>
	                </div>
	                <h4><a href="<?php echo $link ?>"><?php echo CHtml::encode( $news_->title ) ?></a></h4>
	            </div>
		    <?php
		        endforeach;
		    endif;
		    ?>
	    </div>
	    <div class="front-column">
	    	<?php
		    if ( !empty( $col2_news ) ) :
		        foreach ( $col2_news AS $news_ ) :
					// Get link of article
					if ( empty( $news_->alias ) )
					{
						$link = '/' . strtolower( $news_->section ) . '/' . $news_->id;
					}
					else {
						$link = '/' . strtolower( $news_->section ) . '/' . $news_->id . ':' . $news_->alias;
					}
					$link = Yii::app( )
						->createAbsoluteUrl( $link );
					// Get image of article
					$image = Helper::getThumbImage( $news_->body );
                    if ( empty( $image ) ) 
                    {
                        $image = '/images/no_image.png';
                    }
					$image = Yii::app( )
						->createAbsoluteUrl( $image );
		    ?>
	            <div class="frontItem">
	                <div class="small-image">
	                	<a href="<?php echo $link ?>">
	                    	<img src="<?php echo $image; ?>" title="<?php echo CHtml::encode( $news_->title ) ?>" />
	                	</a>
	                </div>
	                <h4><a href="<?php echo $link ?>"><?php echo CHtml::encode( $news_->title ) ?></a></h4>
	            </div>
		    <?php
		        endforeach;
		    endif;
		    ?>
	    </div>
	    <div class="clear"></div>
    <?php 
        endif;
    endif; 
    ?>
</div>
<div id="frontRight" class="front-column">
    <?php
    if ( !empty( $col3_news ) ) :
        foreach ( $col3_news AS $news_ ) :
			// Get link of article
			if ( empty( $news_->alias ) )
			{
				$link = '/' . strtolower( $news_->section ) . '/' . $news_->id;
			}
			else {
				$link = '/' . strtolower( $news_->section ) . '/' . $news_->id . ':' . $news_->alias;
			}
			$link = Yii::app( )
				->createAbsoluteUrl( $link );
			// Get image of article
			$image = Helper::getThumbImage( $news_->body );
            if ( empty( $image ) ) 
            {
                $image = Yii::app()->theme->baseUrl . '/images/no_image.png';
            }
			$image = Yii::app( )
				->createAbsoluteUrl( $image );
            ?>
            <div class="frontItem">
                <div class="small-image">
                	<a href="<?php echo $link ?>">
                    	<img src="<?php echo $image; ?>" title="<?php echo CHtml::encode( $news_->title ) ?>" />
                	</a>
                </div>
                <h4><a href="<?php echo $link ?>"><?php echo CHtml::encode( $news_->title ) ?></a></h4>
            </div>
            <?php
        endforeach;
    endif;
    ?>
</div>
<div class="clear"></div>

