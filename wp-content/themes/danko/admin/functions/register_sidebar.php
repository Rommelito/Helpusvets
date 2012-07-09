<?php
	if(function_exists('register_sidebar')){
		register_sidebar(array(
						'name'          => 'Sidebar',
						'before_widget' => '<div class="sidebar_widget_holder %s">',
						'after_widget'  => '<div class="widget-down"></div></div>',
						'before_title'  => '<h3 class="sidebar_widgettitle">',
						'after_title'   => '</h3>' )
						);



	}

        if(function_exists('register_sidebar')){
		register_sidebar(array(
						'name'          => 'Footer Widget 1',
						'before_widget' => '<div class="sidebar_widget_holder  %s"><div class="widget-bg-top"></div>',
						'after_widget'  => '<div class="widget-bg-down"></div></div>',
						'before_title'  => '<h3 class="sidebar_widgettitle">',
						'after_title'   => '</h3>' )
						);
	}

	if(function_exists('register_sidebar')){
		register_sidebar(array(
						'name'          => 'Footer Widget 2',
						'before_widget' => '<div class="sidebar_widget_holder  %s"><div class="widget-bg-top"></div>',
						'after_widget'  => '<div class="widget-bg-down"></div></div>',
						'before_title'  => '<h3 class="sidebar_widgettitle">',
						'after_title'   => '</h3>' )
						);
	}

        if(function_exists('register_sidebar')){
        register_sidebar(array(
						'name'          => 'Footer Widget 3',
						'before_widget' => '<div class="sidebar_widget_holder  %s"><div class="widget-bg-top"></div>',
						'after_widget'  => '<div class="widget-bg-down"></div></div>',
						'before_title'  => '<h3 class="sidebar_widgettitle">',
						'after_title'   => '</h3>' )
						);
	}





	$dynamic_sidebar = get_option(THEME_NAME."_sidebar");

	$dynamic_sidebar = unserialize($dynamic_sidebar);

		if(!empty($dynamic_sidebar))
		{
			foreach($dynamic_sidebar as $sidebar)
			{
				if ( function_exists('register_sidebar') )
			    register_sidebar(array('name' => $sidebar,'before_widget' => '<span class="sidebar_widget_holder %s">',
						'after_widget'  => '</span>',
						'before_title'  => '<h2 class="sidebar_widgettitle">',
						'after_title'   => '</h2>'));
			}
		}


?>