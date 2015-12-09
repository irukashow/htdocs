﻿<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $title_for_layout; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
        <script src="http://code.jquery.com/jquery-1.10.0.js"></script>
        <script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
        <script type="text/javascript">
            <!--
        $(document).bind("mobileinit", function(){
            $.mobile.ajaxEnabled = false;
            $.mobile.ajaxLinksEnabled = false; // Ajax を使用したページ遷移を無効にする
            $.mobile.ajaxFormsEnabled = false; // Ajax を使用したフォーム遷移を無効にする
        });
        -->
         </script>

        <?php
            echo $this->Html->css('main_m');
            echo $this->Html->css('jquery.checkbox');
            echo $this->Html->script('sample1');
            echo $this->Html->script('jquery.checkbox.min');
        ?>
    </head>
    <body>
        <?php echo $content_for_layout; ?>
    </body>
</html>