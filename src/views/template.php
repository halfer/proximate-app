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
        <div>
            <a href="/">Home</a>
            |
            <a href="/crawl">Crawl</a>
            |
            <a href="/proxy-test">Proxy test</a>
        </div>
        <?php echo $this->section('content') ?>
    </body>
</html>
