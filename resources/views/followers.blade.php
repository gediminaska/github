<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head></head>
<body>
<h1>Followers of {{ $login }}</h1>
<table>
    <tr>
        <th>Display picture</th>
        <th>Username</th>
    </tr>
    @foreach($followers as $follower)
        <tr>
            <td>
                <img src="{{ $follower->avatar_url }}" alt="" style="height: 50px; width: 50px; border-radius: 25px">
            </td>
            <td>
                <p>
                    {{ $follower->login }}
                </p>
            </td>
        </tr>
    @endforeach
</table>
{{--{{ $links[0] }}--}}
<div id="app">
    <button @click="getNext()">Load more</button>
</div>
</body>
<script src="{{ asset('js/app.js') }}"></script>
<script>
    window.Laravel = '{!! json_encode([
            'csrfToken' => csrf_token(),
          ]) !!}';
    const app = new Vue({
        el: '#app',
        data: {
            followers: {},
            nextLink: "",
        },
        methods: {
            getNext() {
                axios.get('https://api.github.com/user/463230/followers?page=2')
                    .then((response) => {
                        this.followers.unshift(response.data)
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
        }
    });
</script>
</html>
