<!DOCTYPE html>
<html>
   <head>
        <title><?php echo $aConfig['meta-title']; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

        <!-- Reset all CSS rule -->
        <link rel="stylesheet" href="<?php echo CSSPATH; ?>reset.css" />
        
        <!-- Main stylesheed  (EDIT THIS ONE) -->
        <link rel="stylesheet" href="<?php echo CSSPATH; ?>style.css" />
        
        <!-- jQuery AND jQueryUI -->
        <!--<script type="text/javascript" src="<?php echo JSPATH; ?>jquery.min.js"></script>-->
	    <script src="<?=JSPATH?>jquery-1.7.1.min.js" ></script>
	    <script type="text/javascript" src="<?php echo JSPATH; ?>jquery-ui.min.js"></script>
        <link rel="stylesheet" href="<?php echo CSSPATH; ?>jqueryui/jqueryui.css" />
        
        <!-- jWysiwyg - https://github.com/akzhan/jwysiwyg/ -->
        <link rel="stylesheet" href="<?php echo JSPATH; ?>jwysiwyg/jquery.wysiwyg.old-school.css" />
        <script type="text/javascript" src="<?php echo JSPATH; ?>jwysiwyg/jquery.wysiwyg.js"></script>
        
        
        <!-- Tooltipsy - http://tooltipsy.com/ -->
        <script type="text/javascript" src="<?php echo JSPATH; ?>tooltipsy.min.js"></script>
        
        <!-- iPhone checkboxes - http://awardwinningfjords.com/2009/06/16/iphone-style-checkboxes.html -->
        <script type="text/javascript" src="<?php echo JSPATH; ?>iphone-style-checkboxes.js"></script>
        <script type="text/javascript" src="<?php echo JSPATH; ?>excanvas.js"></script>
        
        <!-- Load zoombox (lightbox effect) - http://www.grafikart.fr/zoombox -->
        <script type="text/javascript" src="<?php echo JSPATH; ?>zoombox/zoombox.js"></script>
        <link rel="stylesheet" href="<?php echo JSPATH; ?>zoombox/zoombox.css" />
        
        <!-- Charts - http://www.filamentgroup.com/lab/update_to_jquery_visualize_accessible_charts_with_html5_from_designing_with/ -->
        <script type="text/javascript" src="<?php echo JSPATH; ?>visualize.jQuery.js"></script>
        
        <!-- Uniform - http://uniformjs.com/ -->
        <script type="text/javascript" src="<?php echo JSPATH; ?>jquery.uniform.min.js"></script>
        
		<!-- autosuggest js-->
		<script type="text/javascript" src="<?php echo JSPATH; ?>jquery.autocomplete.js"></script>
		
		<!-- Common js-->
        <script type="text/javascript" src="<?php echo JSPATH; ?>cms-var.js"></script>
        <script type="text/javascript" src="<?php echo JSPATH; ?>cms.js"></script>
        <script type="text/javascript" src="<?php echo JSPATH; ?>jquery.cookie.js"></script>
		<script type="text/javascript" src="<?php echo JSPATH; ?>tinymce/tinymce.min.js"></script>
		
		<!-- fancybox -->
		<!-- Add fancyBox main JS and CSS files -->
		<script type="text/javascript" src="<?php echo JSPATH; ?>fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo JSPATH; ?>fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
	
		<!-- Uploadify -->
		<script type="text/javascript" src="<?php echo JSPATH; ?>jquery_uploadify/swfobject.js"></script>
		<script type="text/javascript" src="<?php echo JSPATH; ?>jquery_uploadify/jquery.uploadify.v2.1.4.min.js"></script>
		<!-- script type="text/javascript" src="<?php echo JSPATH; ?>jquery_uploadify/jquery.uploadify.v3.2.1.min.js"></script -->
		<link rel="stylesheet" href="<?php echo JSPATH; ?>jquery_uploadify/uploadify.css" type="text/css" />
		<script type="text/javascript">
			$(document).ready(function() {
			/*
			 *  Simple image gallery. Uses default settings
			*/
				//$('.fancybox').fancybox();
				$(".fancybox").fancybox({
					'width'				: '90%',
					'height'			: '55%',
					'autoScale'     	: true,
					'transitionIn'		: 'none',
					'transitionOut'		: 'none',
					'type'				: 'iframe',
					'beforeShow'        : function(){
				   							this.width = $('.fancybox-iframe').contents().find('.bloc').width()+2;
										    this.height = $('.fancybox-iframe').contents().find('.bloc').height();
										  },
					'fitToView '        : false,					  
				});
			});
		</script>
	</head>
	<body class="<?php echo $cTheme;?>">
        <?php
			if(empty($_GET['isPlane'])){
		?>
		<!-- HEAD --> 
        <div id="head">
            <div class="left">
                <a href="#" class="button profile"><img src="<?=IMGPATH?>icons/huser.png" alt="user" /></a>
                Hi, 
                <a href="#"><?=Encryption::dec($_COOKIE['edtname']);?></a>
                |
                <a href="<?=SITEPATH?>login?action=logout">Logout</a>
            </div>
            <div class="right">
				<a href="javascript:void(0);" style="color:#FFF;"><?php echo date('Y-m-d H:i:s'); ?></a>&nbsp;&nbsp;
				<a href="javascript:void(0);" onClick="cms.setTheme({'cTheme':'white'});" style="color:#FFF;">White</a>&nbsp;&nbsp;
                <a href="javascript:void(0);" onClick="cms.setTheme({'cTheme':'black'});" style="color:#000;">Black</a>&nbsp;&nbsp;
                <a href="javascript:void(0);"  onClick="cms.setTheme({'cTheme':'wood'});" style="color:#624A3E;">Wood</a>&nbsp;&nbsp;
				<div style="float:right"><img src="<?=IMGPATH?>logo.png" title="saregama" alt="saregama" height="40" /></div>
				<br style="clear:both"/>
            </div>
        </div>
		<?php
			}
		?>