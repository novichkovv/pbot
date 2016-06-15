<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
<!-- BEGIN HEADER INNER -->
<div class="page-header-inner">
<!-- BEGIN LOGO -->
<div class="page-logo">
    <a href="<?php echo SITE_DIR; ?>">
        <img src="<?php echo SITE_DIR; ?>assets/admin/layout/img/logo.png" alt="logo" class="logo-default"/>
    </a>
    <div class="menu-toggler sidebar-toggler">
        <span></span>
    </div>
<!--    <div class="menu-toggler sidebar-toggler hide">-->
<!--        <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->-->
<!--    </div>-->
</div>
<!-- END LOGO -->
<!-- BEGIN RESPONSIVE MENU TOGGLER -->

<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
</a>
<!-- END RESPONSIVE MENU TOGGLER -->
<!-- BEGIN TOP NAVIGATION MENU -->
<div class="top-menu">


    <ul class="nav navbar-nav pull-right">
        <li>
           <div style="color: #fff; margin-top: 16px;">
               <?php echo registry::get('user')['user_name']; ?>
           </div>
        </li>
        <li class="dropdown dropdown-quick-sidebar-toggler">
            <a href="javascript:;" onclick="document.getElementById('logout-form').submit();" class="dropdown-toggle">
                <i class="icon-logout"></i>
            </a>
        </li>
    <!-- END QUICK SIDEBAR TOGGLER -->
    </ul>
</div>
<!-- END TOP NAVIGATION MENU -->
</div>
<!-- END HEADER INNER -->
</div>
<form method="post" id="logout-form" action="<?php echo SITE_DIR; ?>">
    <input type="hidden" name="log_out" value="1">
</form>
<!-- END HEADER -->