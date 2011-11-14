<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <title><?php echo $TX_PAGE_TITLE ?></title>

        <!-- Reset Stylesheet -->
        <?php echo asset_link_tag('css/admin/reset.css'); ?>
        <?php echo asset_link_tag('css/admin/style.css'); ?>		
        <?php echo asset_link_tag('css/admin/invalid.css'); ?>		
        <?php echo asset_link_tag('css/admin/colorbox/colorbox.css'); ?>	


        <!--[if lte IE 7]>
        <?php echo asset_link_tag('css/admin/ie.css'); ?>					
        <![endif]-->

        <!-- jQuery -->
        <?php echo asset_js('js/jquery-1.6.4.js') ?>
        <?php echo asset_js('js/admin/jquery.colorbox-min.js'); ?>
        <?php echo asset_js('js/admin/jquery.configuration.js'); ?>		


        <!--[if IE]>
        <?php echo asset_js('js/admin/jquery.bgiframe.js'); ?>		
        <![endif]-->

        <!-- Internet Explorer .png-fix -->

        <!--[if IE 6]>
        <?php echo asset_js('js/admin/DD_belatedPNG_0.0.7a.js'); ?>					
            <script type="text/javascript">
                DD_belatedPNG.fix('.png_bg, img, li');
            </script>
        <![endif]-->
        <?php
        $config = array(
            'base_url' => $this->config->slash_item('base_url'),
            'site_url' => site_url(),
            'ajax_url' => site_url('ajax'),
            'asset_url' => asset_url(),
            'date_format' => jdate_format($this->config->item('date_format'))
        );
        ?>
        <script type="text/javascript">
            var _admin = <?php echo json_encode($config) ?>;
        </script>

    </head>

    <body>
        <div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->
            <?php if ($this->my_auth->logged_in(TRUE)): ?>

                <div id="sidebar"><div id="sidebar-wrapper"> <!-- Sidebar with logo and menu -->

                        <h1 id="sidebar-title"><?php echo lang('admin_manager_title'); ?></h1>

                        <!-- Sidebar Profile links -->
                        <div id="profile-links">
                            Hello, Admin<br />
                            <br />
                            <a href="<?php echo site_url(); ?>" title="View the Site">View the Site</a> | <a href="<?php echo site_url('admin/admin/logout'); ?>" title="<?php echo lang('authen_logout'); ?>"><?php echo lang('authen_logout'); ?></a>
                        </div>        

                        <ul id="main-nav">  <!-- Accordion Menu -->

                            <li>
                                <!-- Add the class "no-submenu" to menu items with no sub menu -->
                                <a href="<?php echo site_url('admin/dashboard') ?>" class="nav-top-item no-submenu <?php admin_menu_current('dashboard'); ?>">Dashboard</a>
                            </li>

                            <li> 
                                <?php
                                $managers = array(
                                    'admin' => lang('admin_manager_admin'),
                                    'users' => lang('admin_manager_user'),
                                    'building_type' => lang('admin_manager_building_type'),
                                        )
                                ?>
                                <a href="#" class="nav-top-item <?php admin_menu_current('manager') ?>"><?php echo lang('admin_manager_submenu'); ?></a>
                                <ul>
                                    <?php admin_menu_render($managers); ?>
                                </ul>
                            </li>

                        </ul> <!-- End #main-nav -->			


                    </div></div> <!-- End #sidebar -->

                <div id="main-content"> <!-- Main Content Section with everything -->
                    <?php echo $PAGE_CONTENT ?>

                    <div id="footer">
                        <small> <!-- Remove this notice or replace it with whatever you want -->
                            &#169; Copyright 2011 Trương Nam Kiên | Powered by Trương Nam Kiên | <a href="#">Top</a>
                        </small>
                    </div><!-- End #footer -->
                </div> <!-- End #main-content -->
            </div>
        <?php else: ?>
            <div id="login">
                <?php echo $PAGE_CONTENT ?>
            </div>
        <?php endif; ?>
    </body> 
</html>
<?php
$uri_segment = $this->uri->segment(2);

/**
 * check xem menu nào là current.
 */
function admin_menu_current($menu_name) {
    global $uri_segment;
    if ($uri_segment == $menu_name) {
        echo 'current';
    }
}

/**
 * render ra các menu ul > li
 */
function admin_menu_render($params) {
    $menu = '';
    foreach ($params as $type => $text) {
        $menu .= '<li><a href="' . site_url('admin/' . $type) . '"';
        $menu .= 'class="' . admin_menu_current($type) . '">';
        $menu .= $text . '</a></li>';
    }
    echo $menu;
}
?>