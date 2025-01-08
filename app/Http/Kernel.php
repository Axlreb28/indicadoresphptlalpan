
protected $routeMiddleware = [
    // Otros middleware...
    'role.redirect' => \App\Http\Middleware\RoleRedirect::class,
];
