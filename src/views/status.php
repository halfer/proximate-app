<?php $this->layout('template') ?>

<?php /* @todo Can this be moved into the template? */ ?>
<?php if ($error): ?>
    <p style="color: red;">
        <?php echo htmlspecialchars($error, null, 'UTF-8') ?>
    </p>
<?php endif ?>

<p>
    Items waiting to be moved to the playback service:
</p>

<table>
    <?php foreach ($sites as $site): ?>
        <tr>
            <td>
                <?php echo htmlentities($site) ?>
            </td>
        </tr>
    <?php endforeach ?>
    <?php if (!$sites): ?>
        <tr>
            <td>
                (No items)
            </td>
        </tr>
    <?php endif ?>
</table>
