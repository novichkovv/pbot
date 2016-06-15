<tr class="phrase_form" id="<?php echo isset($form_id) ? $form_id : 'add_form'; ?>"
    <?php if ($phrase['id']): ?>
        data-tr="<?php echo $phrase['id']; ?>"
    <?php endif; ?>
    <?php if (!$phrase): ?>
        style="display: none;"
    <?php endif; ?>>
    <th style="width: 32px;"></th>
    <td style="width: 150px;">
        <select class="form-control" name="phrase[status_id]">
            <?php if ($statuses): ?>
                <?php foreach ($statuses as $status): ?>
                    <option value="<?php echo $status['id']; ?>"
                        <?php if ($phrase['status_id'] == $status['id']): ?>
                            selected
                        <?php endif; ?>>
                        <?php echo $status['status_name']; ?>
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </td>
    <td style="width: 70px;">
        <input type="text" name="phrase[sort_order]" value="<?php echo $phrase['sort_order']; ?>" class="form-control">
    </td>
    <td style="width: 70px;">
        <input type="text" name="phrase[delay]" value="<?php echo $phrase['delay']; ?>" class="form-control">
    </td>
    <td>
        <textarea class="form-control" name="phrase[mask]" rows="4"><?php echo $phrase['mask']; ?></textarea>
    </td>
    <td>
        <textarea class="form-control" name="phrase[reply]" rows="4"><?php echo $phrase['reply']; ?></textarea>
    </td>
    <td>
        <?php if ($phrase['id']): ?>
            <input type="hidden" name="phrase[id]" value="<?php echo $phrase['id']; ?>"> 
        <?php endif; ?>
        <input type="hidden" name="phrase[campaign_id]" value="<?php echo $campaign_id ? $campaign_id : $phrase['campaign_id']; ?>">
        <button type="button" class="btn btn-info save_phrase_btn">Save</button>
        <button type="button" class="btn btn-warning cancel">Cancel</button>
    </td>
</tr>