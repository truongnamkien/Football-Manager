<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>
            <?php
            // page title
            if ($PAGE_TITLE != '') {
                echo PAGE_TITLE . ' - ' . $PAGE_TITLE;
            } else {
                echo PAGE_TITLE;
            }
            ?>
        </title>
        <script type="text/javascript">
            var _asset_url = '<?php echo asset_url(); ?>';
        </script>
        <?php
        // css
        echo asset_link_tag('css/default.css');
        // js
        echo asset_js('js/jquery.js');
        echo asset_js('js/core.js');
        ?>
    </head>
    <body>

        <div id="container">
            <?php
            // page content
            echo $PAGE_CONTENT;
            ?>
        </div>

    </body>
</html>