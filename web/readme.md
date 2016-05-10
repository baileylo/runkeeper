# Development Web Server

RunKeeper runs on OAuth2. To receive your client token, you must jump
through some web pages, this directory can be used to do that, but should
only be used for development. Run the following code in your terminal
from the root of the runkeeper app(../ is the relative path from here).

You'll also need to set up your client_id and client_secret in `web/.env`.
You can access these values from [RunKeeper](https://runkeeper.com/partner/applications/keysAndURLs).
The script will spit out some JSON, you just need to copy your auth token.

```
php -S localhost:8888 -t web/
```

