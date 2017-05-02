<?php $this->layout('template') ?>

<p>
    Tail of proxy logs:
</p>

<table>
    <?php foreach ($logLines as $line): ?>
        <tr>
            <td>
                <?php echo htmlentities($line, null, 'UTF-8') ?>
            </td>
        </tr>
    <?php endforeach ?>
</table>
