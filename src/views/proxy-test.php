<?php $this->layout('template') ?>

<p>
    Proxy address: <?php echo htmlspecialchars($proxyAddress, null, 'UTF-8') ?>
</p>

<p>
    <?php if ($ok): ?>
        Recorded <a href="<?php echo htmlspecialchars($targetSite, null, 'UTF-8') ?>">a test site</a>
        containing <?php echo $byteCount ?> bytes successfully.
    <?php else: ?>
        Failed to record
        <a href="<?php echo htmlspecialchars($targetSite, null, 'UTF-8') ?>">a test site</a>
        via the proxy. The error was <em><?php echo htmlspecialchars($error, null, 'UTF-8') ?></em>.
    <?php endif ?>
</p>
