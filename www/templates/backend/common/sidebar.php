<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
            <li class="sidebar-search-wrapper hidden-xs">
                <form class="sidebar-search" action="" method="POST">
                    <a href="javascript:;" class="remove">
                        <i class="icon-close"></i>
                    </a>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                        <a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
                        </span>
                    </div>
                </form>
            </li>
            <li class="start <?php if(registry::get('route_parts')[0] == 'index') echo 'active'; ?>">
                <a href="<?php echo SITE_DIR; ?>">
                    <i class="icon-home"></i>
                    <span class="title">Dashboard</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="<?php if(registry::get('route_parts')[0] == 'upload') echo 'active'; ?>">
                <a href="<?php echo SITE_DIR; ?>upload/">
                    <i class="icon-cloud-upload"></i>
                    <span class="title">Upload</span>
                </a>
            </li>
            <li class="<?php if(registry::get('route_parts')[0] == 'data') echo 'active'; ?>">
                <a href="<?php echo SITE_DIR; ?>data/">
                    <i class="icon-list"></i>
                    <span class="title">Data</span>
                </a>
            </li>
        </ul>
    </div>
</div>