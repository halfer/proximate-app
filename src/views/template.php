<!DOCTYPE html>
<html>
    <head>
        <style>
            table {
                border-collapse: collapse;
            }
            table td, table th {
                border: 1px solid silver;
                padding: 4px;
            }
        </style>
    </head>
    <body>
        <div style="margin-bottom: 4px;">
            <a href="/">Home</a>
            |
            <a href="/crawl">Crawl</a>
            |
            <a href="/crawl/queue">Crawl queue</a>
            |
            <a href="/proxy/test">Proxy test</a>
            |
            <a href="/proxy/log">Proxy log</a>
        </div>
        <?php echo $this->section('content') ?>
    </body>
</html>
