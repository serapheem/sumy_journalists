<?php
$cs = Yii::app()->getClientScript();  
$cs->registerScriptFile(Yii::app()->theme->baseUrl .'/js/jcarousellite_1.0.1.min.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl .'/js/jquery.mousewheel.min.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl .'/js/jquery.fancybox-1.3.4.pack.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl .'/js/jquery.easing-1.3.pack.js', CClientScript::POS_END);
$cs->registerCssFile(Yii::app()->theme->baseUrl .'/css/jquery.fancybox-1.3.4.css');
$cs->registerScript(
    'gallery',
    'jQuery(document).ready(function($)
    {
        $("#gallery .prev, #gallery .next").click(function(event)
        {
            event.preventDefault()
        });
        $("#gallery").jCarouselLite(
        {
            btnNext: "#gallery .next",
            btnPrev: "#gallery .prev",
            mouseWheel: true,
            circular: false,
            visible: 4
        });
        $("#gallery li").each(function(index, item)
        {
            var wrapper = $(item).height();
            var image = $(item).children().children();
            var image_height = $(image).height();
            var margin = parseInt( $(item).children().children().css("margin-top") );
                
            if ( (wrapper - (image_height + 2 * margin)) > 10)
            {
                var new_margin = parseInt( (wrapper - image_height) / 2);
                $(item).children().children().css("margin-top", new_margin + "px")
            }
        });
        $("a[rel=gallery]").fancybox(
        {
            transitionIn  : "elastic",
            transitionOut : "elastic",
            titlePosition : "over"
        });
        
    })',
    CClientScript::POS_END
);
?>
<div id="gallery">
    <a href="#" class="prev"></a>
    <div class="items-block">
        <ul>
            <?php foreach ($small_images_url AS $index => $image) : ?>
            <li>
                <a rel="gallery" href="<?php echo $images_url[$index] ?>"><img id="image-<?php echo $index ?>" src="<?php echo $image ?>" alt="" /></a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <a href="#" class="next"></a>
    <div class="clr"></div>
</div>