<?php $this->layout('template') ?>

<?php if ($error): ?>
    <p style="color: red;">
        <?php echo htmlspecialchars($error, null, 'UTF-8') ?>
    </p>
<?php endif ?>

<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Site</th>
            <th>Path</th>
            <th>Method</th>
            <th></th>
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
            <td>
                <form
                    method="post"
                    action="/delete/<?php echo htmlspecialchars($url['id'], null, 'UTF-8') ?>"
                >
                    <input type="submit" value="Delete" />
                </form>
            </td>
        </tr>
    <?php endforeach ?>
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
