<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $PAGE_TITLE ?></title>

        <!-- Reset Stylesheet -->
        <?php echo asset_link_tag('css/admin/reset.css'); ?>
        <?php echo asset_link_tag('css/admin/style.css'); ?>
        <?php echo asset_link_tag('css/client.css'); ?>
        <?php echo asset_link_tag('css/common.css'); ?>
        <?php echo asset_link_tag('css/colorbox/colorbox.css'); ?>

        <!-- jQuery -->
        <?php echo asset_js('js/jquery-1.6.4.js') ?>
        <?php echo asset_js('js/jquery.colorbox-min.js'); ?>
        <?php echo asset_js('js/admin/jquery.configuration.js'); ?>
        <?php echo asset_js('js/core.js'); ?>

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
        <div id="body-wrapper">
            <div id="sidebar">
                <div id="sidebar-title">
                    <?php echo Modules::run('profile/_user_info'); ?>
                </div>

                <div id="sidebar-wrapper">
                    <?php echo Modules::run('navigator/_main_nav'); ?>
                </div>
            </div>

            <div id="main-content">
                <?php echo $PAGE_CONTENT ?>

                <div id="footer">
                    <small> <!-- Remove this notice or replace it with whatever you want -->
                        &#169; Copyright 2011 Trương Nam Kiên | Powered by Trương Nam Kiên | <a href="#">Top</a>
                    </small>
                </div><!-- End #footer -->
            </div> <!-- End #main-content -->
        </div>
    </body> 
</html>
