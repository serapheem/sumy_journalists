<?php
$cs = Yii::app()->getClientScript();  
$cs->registerCssFile(Yii::app()->theme->baseUrl .'/css/redmond/jquery-ui-1.8.16.custom.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl .'/js/jquery-ui-1.8.16.custom.min.js', CClientScript::POS_END);
/*$cs->registerScript(
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
);*/
?>
<script type="text/javascript">
    jQuery(function($) 
    {
        $("#comments").tabs()   
    });
</script>
<div id="comments">
    <ul class="comments-navigation">
        <li><a class="" href="#vkontakte-comments">ВКонтакте</a></li>
        <li><a class="" href="#facebook-comments">Facebook</a></li>
    </ul>
    
    <div id="vkontakte-comments">
        <div id="vk_comments"></div>
        <script type="text/javascript">
            VK.Widgets.Comments("vk_comments", {limit: 10, width: "685", attach: "*"});
        </script>
    </div>
    <div id="facebook-comments">
        <div class="fb-comments" data-num-posts="10" data-width="685"></div>
    </div>
</div>
