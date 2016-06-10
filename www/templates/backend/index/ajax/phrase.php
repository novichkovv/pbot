<tr data-id="<?php echo $phrase['id']; ?>">
    <td><input class="phrase_check" name="check[<?php echo $phrase['id']; ?>]" type="checkbox" value="<?php echo $phrase['id']; ?>"></td>
    <td><?php echo $phrase['status_name']; ?></td>
    <td><?php echo $phrase['sort_order']; ?></td>
    <td><?php echo $phrase['delay']; ?></td>
    <td><?php echo $phrase['mask']; ?></td>
    <td><?php echo $phrase['reply']; ?></td>
    <td>
        <button type="button" class="btn btn-default btn-icon edit_phrase"><i class="fa fa-edit"></i> </button>
        <button type="button" class="btn btn-default btn-icon clone_phrase"><i class="fa fa-copy"></i> </button>
        <a href="#delete_modal" data-toggle="modal" class="btn btn-default btn-icon delete_phrase">
            <i class="fa fa-trash"></i>
        </a>
    </td>
</tr>