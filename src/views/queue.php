<?php $this->layout('template') ?>

<p>
    In progress:
</p>

<table>
    <thead>
        <tr>
            <th>Key</th>
            <th>URL</th>
            <th>Path regex</th>
            <th>Queued time</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($doingRows as $queueRow): ?>
            <tr>
                <td><?php echo htmlentities($queueRow['key'], null, 'UTF-8') ?></td>
                <td><?php echo htmlentities($queueRow['url'], null, 'UTF-8') ?></td>
                <td><?php echo htmlentities($queueRow['path_regex'], null, 'UTF-8') ?></td>
                <td><?php echo htmlentities($queueRow['timestamp_queued'], null, 'UTF-8') ?></td>
            </tr>
        <?php endforeach ?>
        <?php if (!$doingRows): ?>
            <tr>
                <td colspan="4">
                    No queue items in progress.
                </td>
            </tr>
        <?php endif ?>
    </tbody>
</table>

<p>
    Failed:
</p>

<table>
    <thead>
        <tr>
            <th>Key</th>
            <th>URL</th>
            <th>Path regex</th>
            <th>Error</th>
            <th>Queued time</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($errorRows as $queueRow): ?>
            <tr>
                <td><?php echo htmlentities($queueRow['key'], null, 'UTF-8') ?></td>
                <td><?php echo htmlentities($queueRow['url'], null, 'UTF-8') ?></td>
                <td><?php echo htmlentities($queueRow['path_regex'], null, 'UTF-8') ?></td>
                <td><?php echo htmlentities($queueRow['error'], null, 'UTF-8') ?></td>
                <td><?php echo htmlentities($queueRow['timestamp_queued'], null, 'UTF-8') ?></td>
            </tr>
        <?php endforeach ?>
        <?php if (!$errorRows): ?>
            <tr>
                <td colspan="5">
                    No queue items in an error state.
                </td>
            </tr>
        <?php endif ?>
    </tbody>
</table>
