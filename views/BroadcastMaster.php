<?php

namespace PHPMaker2022\pubinamarga;

// Table
$broadcast = Container("broadcast");
?>
<?php if ($broadcast->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_broadcastmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($broadcast->start_date->Visible) { // start_date ?>
        <tr id="r_start_date"<?= $broadcast->start_date->rowAttributes() ?>>
            <td class="<?= $broadcast->TableLeftColumnClass ?>"><?= $broadcast->start_date->caption() ?></td>
            <td<?= $broadcast->start_date->cellAttributes() ?>>
<span id="el_broadcast_start_date">
<span<?= $broadcast->start_date->viewAttributes() ?>>
<?= $broadcast->start_date->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($broadcast->status->Visible) { // status ?>
        <tr id="r_status"<?= $broadcast->status->rowAttributes() ?>>
            <td class="<?= $broadcast->TableLeftColumnClass ?>"><?= $broadcast->status->caption() ?></td>
            <td<?= $broadcast->status->cellAttributes() ?>>
<span id="el_broadcast_status">
<span<?= $broadcast->status->viewAttributes() ?>>
<?= $broadcast->status->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
