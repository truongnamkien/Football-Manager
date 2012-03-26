<ul id="main-nav">
    <?php foreach ($main_navs as $main => $navs): ?>
        <li> 
            <a href="#" class="nav-top-item <?php echo Modules::run('admin/admin_navigator/_menu_current', $navs); ?>"><?php echo lang('manager_submenu_' . $main); ?></a>
            <ul>
                <?php foreach ($navs as $nav): ?>
                    <li>
                        <a href="<?php echo site_url('admin/' . $nav); ?>" class="<?php echo Modules::run('admin/admin_navigator/_menu_current', array($nav)); ?>">
                            <?php echo lang('manager_' . $nav); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>
    <?php endforeach; ?>
</ul>