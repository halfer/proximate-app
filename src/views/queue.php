<?php $this->layout('template') ?>

<p>
    In progress:
</p>

<table>
    <?php foreach ($doingRows as $queueRow): ?>
        <tr>
            <td><?php echo htmlentities($queueRow['url'], null, 'UTF-8') ?></td>
            <td><?php echo htmlentities($queueRow['path_regex'], null, 'UTF-8') ?></td>
        </tr>
    <?php endforeach ?>
</table>

<p>
    Failed:
</p>

<table>
    <?php foreach ($errorRows as $queueRow): ?>
        <tr>
            <td><?php echo htmlentities($queueRow['url'], null, 'UTF-8') ?></td>
            <td><?php echo htmlentities($queueRow['path_regex'], null, 'UTF-8') ?></td>
        </tr>
    <?php endforeach ?>
</table>
