<?php $this->layout('template') ?>

<p>
    <?php echo htmlspecialchars($proxyAddress, null, 'UTF-8') ?>
</p>

<p>
    <?php if ($ok): ?>
        Recorded <?php echo htmlspecialchars($targetSite, null, 'UTF-8') ?> containing
        <?php echo $byteCount ?> successfully.
    <?php else: ?>
        Failed to record <?php echo htmlspecialchars($targetSite, null, 'UTF-8') ?> via the
        proxy.
    <?php endif ?>
</p>
