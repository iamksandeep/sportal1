<?php
/*
  Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/markitup/jquery.markitup.js');
  Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/markitup/sets/default/set.js');
  Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/markitup/plug.js');
  Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/js/markitup/skins/markitup/style.css');
  Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/js/markitup/sets/default/style.css');
  */
  Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/tiny_mce/jquery.tinymce.js');

$tm = '
$().ready(function() {
    $("textarea.markItUp").tinymce({
        // Location of TinyMCE script
        script_url : "'.Yii::app()->baseUrl.'/js/tiny_mce/tiny_mce.js'.'",

        // General options
        theme : "advanced",
        plugins : "autolink,lists,iespell,insertdatetime,preview,searchreplace,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,advlist",

        // Theme options
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,bullist,numlist,|,link,unlink,anchor,image,|,insertdate,inserttime,|,code,fullscreen",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,

        // Example content CSS (should be your site CSS)
        content_css : "'.Yii::app()->baseUrl.'/css/tiny_mce.css'.'",

        // Drop lists for link/image/media/template dialogs
        template_external_list_url : "lists/template_list.js",
        external_link_list_url : "lists/link_list.js",
        external_image_list_url : "lists/image_list.js",
        media_external_list_url : "lists/media_list.js",

        // Replace values for the template plugin
        template_replace_values : {
            username : "Some User",
            staffid : "991234"
        }
    });
});
';

  Yii::app()->clientScript->registerScript('tinymce', $tm);
?>
