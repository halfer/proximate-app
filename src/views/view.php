<?php $this->layout('template') ?>

<?php
/**
 * Keys available:
 *
 * url
 * key
 * method
 * response
 */
?>

<table>
    <thead>
        <tr>
            <th>URL</th>
            <th>Key</th>
            <th>Method</th>
            <th>Requested</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php echo htmlspecialchars($cacheItem['url'], null, 'UTF-8') ?>
            </td>
            <td>
                <?php echo htmlspecialchars($cacheItem['key'], null, 'UTF-8') ?>
            </td>
            <td>
                <?php echo htmlspecialchars($cacheItem['method'], null, 'UTF-8') ?>
            </td>
            <td>
                -
            </td>
        </tr>
    </tbody>
</table>

<p>Response:</p>

<textarea rows="45" style="width: 100%;">
<?php echo htmlspecialchars($cacheItem['response'], null, 'UTF-8') ?>
</textarea>
