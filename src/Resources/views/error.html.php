<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="noindex,nofollow,noarchive" />
    <title>Something went wrong</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 128 128%22><text y=%221.2em%22 font-size=%2296%22>❌</text></svg>" />
    <style>
        <?= $exception->renderContent('assets/css/error.css.php'); ?>
    </style>

</head>
<body>
<main class="error" role="main">
    <div class="card" role="group" aria-labelledby="error-title">
        <div class="icon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="40" height="40" fill="currentColor">
                <path d="M12 2a10 10 0 1 0 10 10A10.011 10.011 0 0 0 12 2Zm1 14h-2v-2h2Zm0-4h-2V6h2Z"/>
            </svg>
        </div>
        <h1 id="error-title">Something went wrong</h1>
        <p class="message">
            <?= htmlspecialchars($exception->getMessagePublic(), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
        </p>
        <p class="footnote" aria-hidden="true">
            If the problem persists, please contact support.
        </p>
    </div>
</main>
</body>
</html>
