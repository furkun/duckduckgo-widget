<?php
/*
Plugin Name: DuckDuckGo Widget
Plugin URI: https://github.com/furkun/duckduckgo-widget
Description: DuckDuckGo search widget for WordPress.
Version: 1.0
Author: Furkun
Author URI: https://github.com/furkun
License: GPLv3
*/


class WP_Widget_Search_DuckDuckGo extends WP_Widget {

	public function __construct() { // widget actual processes
		$widget_ops = array('classname' => 'widget_search_duckduckgo', 'description' => __( 'DuckDuckGo search widget' , 'search-duckduckgo') );
		parent::__construct('search_duckduckgo', __('DuckDuckGo Widget', 'search-duckduckgo'), $widget_ops);
	}
	
	
	public function widget( $args, $instance ) { // outputs the content of the widget
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
	
		
		echo $before_widget;
		if ( $title ){
			echo $before_title . $title . $after_title;
		}
		
?>

	<script>
    function DuckDuckGoSearch() {
        var searchField = document.getElementById("searchField");
        if (searchField && searchField.value) {
            var query = escape("site:" + window.location.hostname + " " + searchField.value);
            window.open("https://duckduckgo.com/?q=" + query, '_blank');
        }
    }
</script>

<div class="duckduckgosearch">
  <form  onsubmit="DuckDuckGoSearch()" action="javascript:void(0)">
    <input type="text" id="searchField" type="search" value="" placeholder="DuckDuckGo Search" required="required" style="width: 100%;">
</form>
</div>

<?php
		echo $after_widget;
	}

	
	public function form( $instance ) { // outputs the options form on admin
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = strip_tags($instance['title']);

?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'search-duckduckgo'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>


			
<?php
	}
	
	
	public function update( $new_instance, $old_instance ) { // processes widget options to be saved
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '') );
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
	
}
add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_Search_DuckDuckGo");'));
