<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/ui/minified/jquery.ui.core.min.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/ui/minified/jquery.ui.position.min.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/ui/minified/jquery.ui.widget.min.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/ui/jquery.ui.autocomplete.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/1200_24_10_10.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style_phone.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style_tablet.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/text.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/layout.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/jui_css/cupertino/jquery-ui-1.8.18.custom.css" media="screen" />
        <meta name="viewport" content="width=device-width" />
        
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/images/favicon.ico">

        <title><?php echo $this->pageTitle;?></title>
        <meta name="title" content="DealsChrome - Best Deals in One Click" />
        <meta name="description" content="DealsChrome is a daily deal search engine which helps to discover the amazing deals around easily.Currently we are operating in Singapore and expanding to other cities very soon. " />
        <meta name="keywords" content="travel, beauty & wellness, eateries, fun , activity, goods, services, food, drink , deal , search, search engine, aggregator, directory, daily deal, group buying , discount, map, chrome, deal sites, groupon" />
        
        
        <script type="text/javascript">
            
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-27012849-1']);
            _gaq.push(['_setDomainName', 'dealschrome.com']);
            _gaq.push(['_trackPageview']);
            
            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
            
        </script>
    </head>

    <body>
        <?php $this->widget('application.components.JsScriptsExporter.JsScriptsExporter'); ?>
        <?php echo $content; ?>
    </body>
</html>
