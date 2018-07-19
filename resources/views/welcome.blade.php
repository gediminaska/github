<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head></head>
    <body>
        <form action='{{ route('results')}}' method='POST'>
            {{ csrf_field() }}
            <input type="text" name="username" placeholder="Enter username" required minlength=4>
            <button type="submit">Search</button>
        </form>
    </body>
</html>
