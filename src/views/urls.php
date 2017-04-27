<?php $this->layout('template') ?>

<?php /* @todo Can this be moved into the template? */ ?>
<?php if ($error): ?>
    <p style="color: red;">
        <?php echo htmlspecialchars($error, null, 'UTF-8') ?>
    </p>
<?php endif ?>

<table>
    <thead>
        <tr>
            <th>Key</th>
            <th>Url</th>
            <th>Method</th>
            <th>Timestamp</th>
            <th></th>
            <th></th>
        </tr>
    </thead>

    <?php // @todo Add creation date to this? ?>
    <?php foreach ($list as $url): ?>
        <tr>
            <td>
                <?php echo htmlspecialchars($url['key'], null, 'UTF-8') ?>
            </td>
            <td>
                <?php echo htmlspecialchars($url['url'], null, 'UTF-8') ?>
            </td>
            <td>
                <?php echo htmlspecialchars($url['method'], null, 'UTF-8') ?>
            </td>
            <td>
                <?php if (isset($url['timestamp_requested'])): ?>
                    <?php echo $url['timestamp_requested'] ?>
                <?php endif ?>
            </td>
            <td>
                <a href="/view/<?php echo htmlspecialchars($url['key'], null, 'UTF-8') ?>">View</a>
            </td>
            <td>
                <form
                    method="post"
                    action="/delete/<?php echo htmlspecialchars($url['key'], null, 'UTF-8') ?>"
                >
                    <input type="submit" value="Delete" />
                </form>
            </td>
        </tr>
    <?php endforeach ?>
    <?php if (!$list): ?>
        <tr>
            <td colspan="6">
                (No items)
            </td>
        </tr>
    <?php endif ?>
</table>

<p>
    <?php // Pagination device if necessary ?>
    <?php if ($count > count($list)): ?>
        <?php for($p = 1; $p <= ceil($count / $pageSize); $p++): ?>
            <a href="/list/<?php echo $p ?>"
               ><?php echo $p ?></a>
        <?php endfor ?>
    <?php endif ?>

    <?php // Include the full URL count ?>
    (Count: <?php echo $count ?>)
</p>
