
<div class="portlet-title">
    <div class="caption caption-md">
        <i class="icon-bar-chart theme-font hide"></i>
        <span class="caption-subject font-blue-madison bold uppercase">Latest Incoming Message</span>
    </div>
    <div class="actions">
        <a href="<?php echo SITE_DIR; ?>emulator/?campaign=<?php echo $latest['campaign_id']; ?>&user_id=<?php echo $latest['user_id']; ?>&number_id=<?php echo $latest['recipient']; ?>#override"
           class="btn blue btn-outline">
            <i class="fa fa-pencil"></i> Override
        </a>
        <a href="<?php echo SITE_DIR; ?>emulator/?campaign=<?php echo $latest['campaign_id']; ?>&user_id=<?php echo $latest['user_id']; ?>&number_id=<?php echo $latest['recipient']; ?>"
           class="btn btn-outline green">
            <i class="fa fa-link"></i> Go to Chat
        </a>
    </div>
</div>
<div class="portlet-body">
    <div class="general-item-list" id="last_container">
        <div class="item">
            <div class="item-head">
                <div class="item-details">
                    <a href="" class="item-name primary-link"><?php echo $latest['campaign_name']; ?></a>
                    <span class="item-label"><?php echo $latest['phone']; ?></span> at <?php echo date('H:i', $latest['push_date']); ?>
                </div>
                <span class="item-status">

                            </span>
            </div>
            <div class="item-body">
                <?php echo $latest['content']; ?>
            </div>
        </div>
    </div>
</div>