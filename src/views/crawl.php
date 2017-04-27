<?php $this->layout('template') ?>

<form method="post" action="/crawl/go">
    <p>
        Scrape site:
        <input type="text" name="url" />
    </p>

    <p>
        Path regex:
        <input type="text" name="path_regex" />
    </p>

    <input type="submit" value="Go" />
</form>
