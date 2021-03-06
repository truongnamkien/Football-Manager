<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="robots" content="noindex" />
        <title><?php echo $PAGE_TITLE ?></title>

        <!-- Reset Stylesheet -->
        <?php echo asset_link_tag('css/admin/reset.css'); ?>
        <?php echo asset_link_tag('css/admin/style.css'); ?>
        <?php echo asset_link_tag('css/common.css'); ?>

        <!-- jQuery -->
        <?php echo asset_js('js/jquery-1.6.4.js') ?>
        <?php echo asset_js('js/admin/jquery.configuration.js'); ?>

    </head>

    <body id="login">
        <div id="login-wrapper" class="png_bg">
            <div id="login-top">
                <h1><?php echo $PAGE_TITLE ?></h1>
            </div>

            <div id="login-content">
                <?php echo $PAGE_CONTENT; ?>
            </div>
        </div>
    </body>
</html>
