<div class="clearfix"> </div>
<div class="page-container">
    <?php require_once(TEMPLATE_DIR . 'common' . DS . 'sidebar.php'); ?>
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <?php if ($breadcrumbs): ?>
                <div class="page-bar">
                    <ul class="page-breadcrumb">
                        <?php foreach ($breadcrumbs as $k => $crumb): ?>
                            <li>
                                <?php if (($k + 1) < count($breadcrumbs)): ?>
                                    <a href="<?php echo $crumb['route']; ?>">
                                <?php endif; ?>
                                <?php echo $crumb['name']; ?>
                                <?php if (($k + 1) < count($breadcrumbs)): ?>
                                    </a>
                                    <i class="fa fa-circle"></i>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>

                    </ul>
<!--                    <div class="page-toolbar">-->
<!--                        <div class="btn-group pull-right">-->
<!--                            <button type="button" class="btn green btn-sm btn-outline dropdown-toggle" data-toggle="dropdown"> Actions-->
<!--                                <i class="fa fa-angle-down"></i>-->
<!--                            </button>-->
<!--                            <ul class="dropdown-menu pull-right" role="menu">-->
<!--                                <li>-->
<!--                                    <a href="#">-->
<!--                                        <i class="icon-bell"></i> Action</a>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="#">-->
<!--                                        <i class="icon-shield"></i> Another action</a>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="#">-->
<!--                                        <i class="icon-user"></i> Something else here</a>-->
<!--                                </li>-->
<!--                                <li class="divider"> </li>-->
<!--                                <li>-->
<!--                                    <a href="#">-->
<!--                                        <i class="icon-bag"></i> Separated link</a>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </div>-->
<!--                    </div>-->
                </div>
            <?php endif; ?>
            <?php require_once(TEMPLATE_DIR . $template . '.php'); ?>
        </div>
    </div>
    <!-- END CONTENT -->
</div>
