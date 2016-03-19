# Development Web Server

RunKeeper runs on OAuth2. To receive your client token, you must jump
through some web pages, this directory can be used to do that, but should
only be used for development. Run the following code in your terminal
from the root of the runkeeper app(../ is the relative path from here).

```
php -S localhost:8888 -t web/
```

