<?php $this->layout('template') ?>

Count: <?php echo $count ?>

<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Site</th>
            <th>Path</th>
            <th>Method</th>
        </tr>
    </thead>

    <?php // @todo Add creation date to this? ?>
    <?php foreach ($list as $url): ?>
        <tr>
            <td>
                <?php echo htmlspecialchars($url['id'], null, 'UTF-8') ?>
            </td>
            <td>
                <?php echo htmlspecialchars($url['request']['headers']['Host']['equalTo'], null, 'UTF-8') ?>
            </td>
            <td>
                <?php echo htmlspecialchars($url['request']['url'], null, 'UTF-8') ?>
            </td>
            <td>
                <?php echo htmlspecialchars($url['request']['method'], null, 'UTF-8') ?>
            </td>
        </tr>
    <?php endforeach ?>
</table>
