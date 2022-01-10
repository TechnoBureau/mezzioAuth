# Mezzio PDO Based Authentication

It's using mezzio authentication based on PDO Adapter. For migration or table creation
using doctrine orm

* Add below entry on routes.php to register router for authentication

    (new TechnoBureau\mezzioAuth\ConfigProvider())->registerRoutes($app, '/user');

* Add Below Entry on pipeline.php before **RouteMiddleware** to register middleware globally for all routes.


    $app->pipe(SessionMiddleware::class);
    $app->pipe(FlashMessageMiddleware::class);

* Add below entry on pipeline.php before **DispatchMiddleware** to register middleware globally for all routers.

    $app->pipe(UserMiddleware::class);

