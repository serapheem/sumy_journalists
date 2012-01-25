<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--[if lt IE 7]>  
    <div style='border: 1px solid #F7941D; background: #FEEFDA; text-align: center; clear: both; height: 90px; position: relative;'>  
        <div style='position: absolute; right: 3px; top: 3px; font-family: courier new; font-weight: bold;'><a href='#' onclick='javascript:this.parentNode.parentNode.style.display="none"; return false;'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-cornerx.jpg' style='border: none;' alt='Приховати повідомлення'/></a></div>  
        <div style='width: 640px; margin: 0 auto; text-align: left; padding: 0; overflow: hidden; color: black;'>  
            <div style='width: 75px; float: left;'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-warning.jpg' alt='Warning!'/></div>  
            <div style='width: 275px; float: left; font-family: Arial, sans-serif;'>  
                <div style='font-size: 14px; font-weight: bold; margin-top: 12px;'>Ви використовуєте застарілий браузер</div>  
                <div style='font-size: 12px; margin-top: 6px; line-height: 12px;'>Для більш зручної роботи з сайтом, будь ласка, оновіть ваш браузер.</div>  
            </div>  
            <div style='width: 75px; float: left;'><a href='http://www.mozilla-europe.org/ru/firefox/' target='_blank'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-firefox.jpg' style='border: none;' alt='Firefox 3.5'/></a></div>  
            <div style='width: 75px; float: left;'><a href='http://www.microsoft.com/rus/windows/internet-explorer/worldwide-sites.aspx' target='_blank'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-ie8.jpg' style='border: none;' alt='Internet Explorer 8'/></a></div>  
            <div style='width: 73px; float: left;'><a href='http://www.apple.com/ru/safari/download/' target='_blank'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-safari.jpg' style='border: none;' alt='Safari 4'/></a></div>  
            <div style='float: left;'><a href='http://www.google.com/chrome' target='_blank'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-chrome.jpg' style='border: none;' alt='Google Chrome'/></a></div>  
        </div>  
    </div>  
<![endif]-->  
<?php if (stripos($_SERVER['HTTP_USER_AGENT'], 'msie 6') !== false && stripos($_SERVER['HTTP_USER_AGENT'], 'msie 8') === false)
    CApplication::end(); ?>


<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xml:lang="en" lang="en">
    <head>

        <title><?php echo $this->title; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="<?php echo $this->keywords; ?>" />
        <meta name="description" content="<?php echo $this->description; ?>" />
        <meta property="fb:app_id" content="116412811804627" />

        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/style.css" rel="stylesheet" type="text/css" />
        
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery-1.7.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/core.js" type="text/javascript"></script>
        
        <script type="text/javascript" src="http://userapi.com/js/api/openapi.js?34"></script>
        <script type="text/javascript" src="http://userapi.com/js/api/openapi.js?47"></script>
        <script type="text/javascript">
            VK.init({apiId: 2725364, onlyWidgets: true});
        </script>
        
        <!-- Google analytics block -->
        <script type="text/javascript">
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-27560522-1']);
		  _gaq.push(['_trackPageview']);
		
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		</script>
		<!-- Google analytics blocek end -->

    </head>

    <body>
        <div id="wrapper">

            <!-- HEADER -->

            <div id="header">
                <div class="row-1">
                    <div class="fleft"><a href="/"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo.png" title="<?php echo Yii::app()->params['title']; ?>" id="logoImg"/></a></div>
                    <div class="fright" id="clock"></div>
                    <div class="clear"></div>
                </div>

                <div class="row-2">
                    <ul>
                        <li class="m1"><a href="<?php echo Yii::app()->request->baseUrl; ?>/news.html" ><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/news.png" title="Новини"/></a></li>
                        <li class="separator"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/separator.png" title="Separator"/></li>
                        <li class="m2"><a href="<?php echo Yii::app()->request->baseUrl; ?>/top10.html" ><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/top10.png" title="Top 10"/></a></li>
                        <li class="separator"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/separator.png" title="Separator"/></li>
                        <li class="m3"><a href="<?php echo Yii::app()->request->baseUrl; ?>/knowour.html" ><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/know_our.png" title="Знай наших"/></a></li>
                        <li class="separator"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/separator.png" title="Separator"/></li>
                        <li class="m4"><a href="<?php echo Yii::app()->request->baseUrl; ?>/citystyle.html" ><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/city_style.png" title="city - стиль"/></a></li>
                        <li class="separator"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/separator.png" title="Separator"/></li>
                        <li class="m5"><a href="<?php echo Yii::app()->request->baseUrl; ?>/tyca.html" ><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/tyca.png" title="tyca"/></a></li>
                        <li class="separator"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/separator.png" title="Separator"/></li>
                        <li class="m6"><a href="<?php echo Yii::app()->request->baseUrl; ?>/pro-nas.html" ><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/about_us.png" title="Про нас"/></a></li>
                    </ul>
                </div>

            </div>

            <!-- CONTENT -->

            <div id="content">
                <div class="col-1">
                    <div class="stratum"></div>
                    <div class="indent">
                        <div <?php echo $this->class; ?>><?php echo $content; ?></div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="col-2">
                    
                    <?php 
                    if ($this->show_poll): 
                        $poll = $this->getPoll();
                        if (!empty ($poll) && !empty ($poll->items)): 
                        ?>
                        <div class="box poll">
                            <h2>Голосування</h2>
                            <strong><?php echo $poll->name; ?></strong>
                            <?php 
                            $add_vote = true;
                            $session = Yii::app()->session->get('poll');
                            if ( !empty ($session) && in_array($poll->id, $session) )
							{
								$add_vote = false;
							}
							if ($add_vote)
							{
								// Check IP for voted
								$param = array(
											'section' => 'Poll', 
											'item_id' => $poll->id,
											'ip' => $_SERVER['REMOTE_ADDR']
										);
								$voted = VotedIP::model()->findByAttributes( $param );
								if ( !empty($voted->ip) )
								{
									$add_vote = false;
								}
							}
                            ?>
                            
                            <?php if (!$add_vote): ?>
                                <div id="poll">
                                    <?php 
                                    $total = 0;
                                    foreach ($poll->items as $item) {
                                        $total += $item->count;
                                    }
                                    
                                    foreach ($poll->items as $k => $item):
                                        $rate = round( ($item->count * 100 / $total), 2); 
                                    ?>
                                        <div class="vote"><?php echo "{$item->name} - {$item->count} ({$rate}%)"; ?></div>
                                        <div class="imgvote">
                                            <img width="<?php echo $rate; ?>%" height="10" style="border:1px solid black" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/poll<?php echo $k%4; ?>.gif" />
                                        </div>
                                    <?php endforeach; ?>
                                        
                                    <strong>Всього проголосувало: <?php echo $total; ?></strong>
                                </div>
                            <?php else: ?>
                                <div id="poll">
                                <form actions="" method="post">
                                    <ul>
                                        <?php foreach ($poll->items as $k => $item): ?>
                                            <li>
                                                <?php if ($k == 0) $checked = 'checked="checked"'; else $checked = ''; ?>
                                                <input type="radio" value="<?php echo $item->id; ?>" name="vote" id="vote<?php echo $item->id; ?>" <?php echo $checked; ?> />
                                                <label for="vote<?php echo $item->id; ?>"><?php echo $item->name; ?></label>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <input type="hidden" name="poll_id" value="<?php echo $poll->id; ?>" />
                                    <button onclick="addVote(); return false;">Проголосувати</button>
                                </form>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php 
                        endif; 
                    endif; 
                    ?>

                </div>
                <div class="clear"></div>
            </div>

        </div>

        <!-- FOOTER -->
        
        <div id="footer">
            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/icons.png" title="Значки" class="fleft"/>
            <div class="fright">
                Copyright &copy; 2011 Developed by Serapheem
            </div>
        </div>
    </body>
</html>