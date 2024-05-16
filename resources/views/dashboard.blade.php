<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>


    <h1>Bienvenido al Dashboard</h1>
    <p>¡Hola, {{ auth()->user()->name ?? 'noname' }}!</p>
    <p>¡Tu email es {{ auth()->user()->email ?? 'noemail' }}!</p>
    <p>Session</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>

    @role('admin')
    <p>This is visible to users with the admin role. Gets translated to
        \Laratrust::hasRole('admin')</p>
    @endrole

    @permission('create-user')
    <p>This is visible to users with the given permissions. Gets translated to
        \Laratrust::hasPermission(create-user').
        @endpermission
</body>

</html>