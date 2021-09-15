<?php 
$footer_layout_number = get_theme_mod('footer_column_number');
$footer_layout =get_theme_mod('footer_layout');
$footer_elem_class=get_footer_widget_class($footer_layout);

$helper =0;
	for( $i=0; $i < $footer_layout_number; $i++ ){
		$footer_slug_number = $i+1;
		$footer_slug ='footer-'.$footer_slug_number;
		if(array_key_exists($i, $footer_elem_class)){?>
			<div class="col-md-<?php echo $footer_elem_class[$i]?> footer-column-<?php echo $footer_slug_number; ?>"><?php dynamic_sidebar($footer_slug);?></div>
			<?php 
		}else { 
			if(!array_key_exists($helper, $footer_elem_class)){ $helper=0;}
			?>
			<div class="col-md-<?php echo $footer_elem_class[$helper]?> footer-column-<?php echo $footer_slug_number; ?>"><?php dynamic_sidebar($footer_slug);?></div>
			<?php 
			$helper++;
		}	
	}	
?>