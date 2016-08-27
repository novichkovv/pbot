<ul class="chats">
    <?php if ($messages): ?>
        <?php foreach ($messages as $message): ?>
            <li class="<?php echo $message['incoming'] ? 'in' : 'out'; ?>">
                <img class="avatar" alt="" src="<?php echo SITE_DIR; ?>assets/admin/layout/img/avatar<?php echo $message['incoming'] ? '1' : '2'; ?>.jpg" />
                <div class="message">
                    <span class="arrow"> </span>
                    <a href="javascript:;" class="name"> <?php echo $message['incoming'] ? 'User ' . $message['phone'] : 'Bot'; ?> </a>
                    <span class="datetime"> at
                        <?php echo $message['time']; ?> </span>
                    <?php if (date('d', strtotime($message['date'])) != date('d')): ?>
                        <?php echo date('d M', strtotime($message['date'])); ?>
                    <?php else: ?>
                        today
                    <?php endif; ?>
                                            <span class="body">
                                                <?php echo $message['text']; ?>
                                            </span>
                </div>
            </li>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>