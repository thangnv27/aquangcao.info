<?php 
/**
 * observer super menu
**/ 
?>
<?php
class ob_super_menu extends Walker_Nav_Menu {
	function start_lvl(&$output, $depth = 0, $args = array()) {
		$output .= "\n<ul id=\"menu-links\">\n";
	}
	function end_lvl(&$output, $depth = 0, $args = array()) {
		$output .= "</ul>\n";
	}
	function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0) {
		global $wp_query;
		$cat = $item->object_id;
		$indent = ($depth) ? str_repeat ( "\t", $depth ) : '';
		$class_names = $value = '';
		$classes = empty ( $item->classes ) ? array () : ( array ) $item->classes;
		$class_names = join ( ' ', apply_filters ( 'nav_menu_css_class', array_filter ( $classes ), $item ) );
		$class_names = ' class="' . esc_attr ( $class_names ) . '"';
		$output .= $indent . '<li data-id="'.$cat.'" rel="' . $item->object_id . '" id="menu-item-' . $item->ID . '"' . $value . $class_names . '>';		
		$attributes = ! empty ( $item->attr_title ) ? ' title="' . esc_attr ( $item->attr_title ) . '"' : '';
		$attributes .= ! empty ( $item->target ) ? ' target="' . esc_attr ( $item->target ) . '"' : '';
		$attributes .= ! empty ( $item->xfn ) ? ' rel="' . esc_attr ( $item->xfn ) . '"' : '';
		$attributes .= ! empty ( $item->url ) ? ' href="' . esc_attr ( $item->url ) . '"' : '';
		$item_output = $args->before;
		$item_output .= '<div class="menua-wrap"><a' . $attributes . ' title="'.$item->title.'" class="menua">';
		$item_output .= $args->link_before . apply_filters ( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a></div>';	
		$item_output .= $args->after;	
		$children = get_posts ( array (
				'post_type' => 'nav_menu_item',
				'nopaging' => true,
				'numberposts' => 1,
				'meta_key' => '_menu_item_menu_item_parent',
				'meta_value' => $item->ID 
		) );		
		if (wp_is_mobile() == false && $depth == 0 && $item->object == 'category' && ! empty ( $children )) {
			$item_output .= '<div class="sub-menu">';
		} elseif ($item->object != 'category' && ! empty ( $children )) {
			$item_output .= '<div class="sub-meni">';
		} elseif ($depth == 0 && $item->object == 'category' && empty ( $children )) {
		}	
		if ($depth == 0 && empty ( $children ) && $item->object == 'category') {
		} elseif ($depth <= 1 && $item->object == 'category') {		
			$cat = $item->object_id;		
			$item_output .= '<ul class="menu-thumbs">';		
//			global $post;
//			$post_args = array (
//					'numberposts' => 6,
//					'offset' => 0,
//					'cat' => $cat 
//			);
//			$menuposts = get_posts ( $post_args );			
//			foreach ( $menuposts as $post ) :
//				setup_postdata ( $post );			
//				$post_title = get_the_title ();
//				$post_link = get_permalink ();
//				$post_image = wp_get_attachment_image_src ( get_post_thumbnail_id ( $post->ID ), "menu-thumb" );				
//				$menu_post_image = '<img class="attachment-media-star-thumb wp-post-image" width="104" height="62" src="' . $post_image [0] . '" alt="' . $post_title . '" />';			
//				$item_output .= '
//								<li>
//								<div class="menu-thumb">
//                                                                    <a class="pull-left" href="' . $post_link . '">' . $menu_post_image . '</a> 
//                                                                <div class="menu-text">	<a href="' . $post_link . '">' . $post_title . '</a></div>    
//                                                                </div>  
//								</li>';
//			endforeach
//			;
//			wp_reset_query ();			
			$item_output .= '</ul>';
		} 
		elseif ($depth == 0 && $item->object == 'page') {
		}		
		$output .= apply_filters ( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
	function end_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0) {
	}
}

