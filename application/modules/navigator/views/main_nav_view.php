<ul id="main-nav">
    <?php foreach ($main_navs as $main => $options): ?>
        <li> 
            <a href="<?php echo (isset($options['url']) && !empty($options['url']) ? $options['url'] : '#'); ?>" class="<?php echo (isset($options['navs']) && !empty($options['navs']) ? '' : 'no-submenu'); ?> nav-top-item <?php echo ($controller == $main ? 'current' : ''); ?>">
                <?php echo lang('navigator_main_nav_' . $main); ?>
            </a>
            <?php if (isset($options['navs']) && !empty($options['navs'])): ?>
                <ul>
                    <?php foreach ($options['navs'] as $sub => $nav): ?>
                        <li>
                            <a href="<?php echo $nav; ?>" class="<?php echo ($method == $sub ? 'current' : ''); ?>">
                                <?php echo lang('navigator_sub_nav_' . $main . '_' . $sub); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>