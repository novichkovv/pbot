<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo SITE_DIR; ?>">
                Home
            </a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            Page Not Found
        </li>
    </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <button type="button" class="btn green btn-sm btn-outline dropdown-toggle" data-toggle="dropdown"> Actions
                <i class="fa fa-angle-down"></i>
            </button>
            <ul class="dropdown-menu pull-right" role="menu">
                <li>
                    <a href="#">
                        <i class="icon-bell"></i> Action</a>
                </li>
                <li>
                    <a href="#">
                        <i class="icon-shield"></i> Another action</a>
                </li>
                <li>
                    <a href="#">
                        <i class="icon-user"></i> Something else here</a>
                </li>
                <li class="divider"> </li>
                <li>
                    <a href="#">
                        <i class="icon-bag"></i> Separated link</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="page-404-3">
    <link href="<?php echo SITE_DIR; ?>assets/pages/css/error.css" rel="stylesheet" type="text/css" />
<!--    <div class="page-inner">-->
<!--        <img src="--><?php //echo SITE_DIR; ?><!--assets/pages/media/pages/earth.jpg" class="img-responsive" alt="">-->
<!--    </div>-->
    <div class="error-404">
        <h1>404</h1>
        <h2>Houston, we have a problem.</h2>
        <p> Actually, the page you are looking for does not exist. </p>
        <p>
            <a href="<?php echo SITE_DIR; ?>" class="btn red btn-outline"> Return home </a>
            <br>
        </p>
    </div>
</div>
<style>
    .page-404-3, .page-404-3 h1,  .page-404-3 h2,  .page-404-3 p
    {
        background: #fff !important;
        color: #666 !important;
    }
</style>