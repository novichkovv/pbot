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
            <li class="start <?php if(registry::get('route_parts')[0] == 'emulator') echo 'active'; ?>">
                <a href="<?php echo SITE_DIR; ?>emulator/">
                    <i class="icon-bubbles"></i>
                    <span class="title">Messages</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="start <?php if(registry::get('route_parts')[0] == 'campaigns') echo 'active'; ?>">
                <a href="<?php echo SITE_DIR; ?>campaigns/">
                    <i class="icon-docs"></i>
                    <span class="title">Campaigns</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="start <?php if(registry::get('route_parts')[0] == 'users' && registry::get('route_parts')[1] != 'blacklist') echo 'active'; ?>">
                <a href="<?php echo SITE_DIR; ?>users/">
                    <i class="icon-users"></i>
                    <span class="title">Users</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="start <?php if(registry::get('route_parts')[0] == 'mass') echo 'active'; ?>">
                <a href="<?php echo SITE_DIR; ?>mass/">
                    <i class="icon-envelope"></i>
                    <span class="title">Mass SMS</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="start <?php if(registry::get('route_parts')[1] == 'blacklist') echo 'active'; ?>">
                <a href="<?php echo SITE_DIR; ?>users/blacklist/">
                    <i class="icon-list"></i>
                    <span class="title">Blacklist</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="start <?php if(registry::get('route_parts')[0] == 'system_users') echo 'active'; ?>">
                <a href="<?php echo SITE_DIR; ?>system_users/">
                    <i class="icon-settings"></i>
                    <span class="title">Options</span>
                    <span class="selected"></span>
                </a>
            </li>
        </ul>
    </div>
</div>