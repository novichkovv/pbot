<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu page-sidebar-menu-closed" data-auto-scroll="true" data-slide-speed="200">
            <li class="start <?php if(registry::get('route_parts')[0] == 'index') echo 'active'; ?>">
                <a href="<?php echo SITE_DIR; ?>">
                    <i class="icon-home"></i>
                    <span class="title">Dashboard</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="start <?php if(registry::get('route_parts')[0] == 'system_users') echo 'active'; ?>">
                <a href="<?php echo SITE_DIR; ?>system_users/">
                    <i class="icon-users"></i>
                    <span class="title">System Users</span>
                    <span class="selected"></span>
                </a>
            </li>
        </ul>
    </div>
</div>