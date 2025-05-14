<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : "Nick Dwtyay - Home"; ?></title>
    <meta name="description" content="<?php echo isset($pageDescription) 
        ? htmlspecialchars($pageDescription) 
        : 'Nick Dwtyay Ltd is a Middle East-based Telecommunications, Cybersecurity Software and Technology Solution Development Company offering innovative solutions to businesses and individuals. Our partnerships in South America give us the opportunity to provide world-class services to our customers.'; ?>" />
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' https://cdnjs.cloudflare.com https://static.cloudflareinsights.com https://pagead2.googlesyndication.com https://www.googletagmanager.com https://www.statcounter.com 'unsafe-inline'; connect-src 'self' https://*.vercel.app https://cloudflareinsights.com https://ipinfo.io https://ipqualityscore.com https://proxycheck.io https://www.google-analytics.com https://stats.g.doubleclick.net https://c.statcounter.com; style-src 'self' 'unsafe-inline'; img-src 'self' https://c.statcounter.com; font-src 'self';">
    <?php if (isset($pageExtraMeta)) echo $pageExtraMeta; ?>
    <link rel="icon" type="image/gif" href="/api/static/dwtyay_favicon.gif">

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/api/public/style.css">
    <!-- Outros links/scripts globais -->
</head>