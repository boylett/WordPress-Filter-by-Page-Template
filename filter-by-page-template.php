<?php 

	/**
	 * Add functionality to filter pages by page template
	 */

	add_action('restrict_manage_posts', function()
	{
		if($GLOBALS['pagenow'] == 'edit.php' and isset($_GET['post_type']) and $_GET['post_type'] == 'page')
		{
			$template = isset($_GET['template']) ? $_GET['template'] : 'all'; 
			$default = apply_filters('default_page_template_title',  __('Default Template'), 'meta-box'); ?>

		<select name="template" id="template">
			<option value="all">All Page Templates</option>
			<option value="default" <?=(($template == 'default') ? ' selected' : '')?>><?=esc_html($default)?></option>
			<? page_template_dropdown($template); ?>
		</select><?
		}
	});

	add_filter('request', function($query)
	{
		if(isset($_GET['template']))
		{
			$template = trim($_GET['template']);

			if($template and $template != 'all')
			{
				$query = array_merge($query, array
				(
					'meta_query' => array
					(
						array
						(
							'key'     => '_wp_page_template',
							'value'   => $template,
							'compare' => '=',
						),
					)
				));
			}
		}

		return $query;
	});
