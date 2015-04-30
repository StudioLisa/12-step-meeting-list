<?php

//for all users
add_action('init', function(){
	global $regions;
	
	register_taxonomy('region', array('meetings'), array(
		'label'=>'Region', 
		'labels'=>array('menu_name'=>'Regions')
	));

	//build quick access array of regions
	$regions = meetings_get_regions();

	register_post_type('meetings',
		array(
			'labels'		=> array(
				'name'			=>	'Meetings',
				'singular_name'	=>	'Meeting',
				'not_found'		=>	'No meetings added yet.',
				'add_new_item'	=>	'Add New Meeting',
				'search_items'	=>	'Search Meetings',
				'edit_item'		=>	'Edit Meeting',
				'view_item'		=>	'View Meeting',
			),
			'supports'		=> array('title', 'revisions'),
			'public'		=> true,
			'has_archive'	=> true,
			'menu_icon'		=> 'dashicons-groups',
		)
	);

	register_post_type('locations',
		array(
			'labels'		=> array(
				'name'			=>	'Locations',
				'singular_name'	=>	'Location',
				'not_found'		=>	'No locations added yet.',
				'add_new_item'	=>	'Add New Location',
			),
	        'taxonomies'	=>	array('region'),
			'supports'		=> array('title', 'revisions'),
			'public'		=> true,
			'show_ui'		=> true,
			'has_archive'	=> true,
			'show_in_menu'	=> 'edit.php?post_type=meetings',
			'menu_icon'		=> 'dashicons-location',
			'capabilities'	=> array('create_posts'=>false),
		)
	);

	//meeting list page
	add_filter('archive_template', function($template) {
		if (is_post_type_archive('meetings')) {
			return dirname(__FILE__) . '/../templates/archive-meetings.php';
		}
		return $template;
	});

	//meeting & location detail pages
	add_filter('single_template', function($template) {
		global $post;
		if ($post->post_type == 'meetings') {
			return dirname(__FILE__) . '/../templates/single-meetings.php';
		} elseif ($post->post_type == 'locations') {
			return dirname(__FILE__) . '/../templates/single-locations.php';
		}
		return $template;
	});

});