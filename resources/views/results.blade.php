<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head></head>
<body>
    <h1>Search results</h1>
    <table>
        <tr>
            <th>Display picture</th>
            <th>Username</th>
            <th>Score</th>
        </tr>
        @foreach($results as $result)
            <tr>
                <td>
                    <img src="{{ $result->avatar_url }}" alt="" style="height: 50px; width: 50px; border-radius: 25px">
                </td>
                <td>
                    <p>
                        {{ $result->login }}
                    </p>
                </td>
                <td>
                    <a href="{{ route('list.followers', $result->login) }}">
                        {{ $result->score }}
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
</body>
</html>
