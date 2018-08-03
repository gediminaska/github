<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head></head>
<body>
<h1>Followers of {{ $login }} ({{ $numberOfFollowers }})</h1>
<div id="app">
    <table>
        <tr>
            <th>Display picture</th>
            <th>Username</th>
        </tr>
        @foreach($followers as $follower)
            <tr>
                <td>
                    <img src="{{ $follower->avatar_url }}" alt=""
                         style="height: 50px; width: 50px; border-radius: 25px">
                </td>
                <td>
                    <p>
                        {{ $follower->login }}
                    </p>
                </td>
            </tr>
        @endforeach
        <div v-if="followers">
            <tr v-for="follower in followers">
                <td>
                    <img :src="follower.avatar_url" alt="" style="height: 50px; width: 50px; border-radius: 25px">
                </td>
                <td>
                    <p v-text="follower.login">
                    </p>
                </td>
            </tr>
        </div>
    </table>

    <div v-if="nextLink">
        <button @click="getNext()">Load more</button>
    </div>
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
            followers: [],
            nextLink: '{!! $secondPageUrl !!}',
        },
        methods: {
            getNext() {
                axios.get(app.nextLink)
                    .then((response) => {
                        response.data.forEach(function (follower) {
                            app.followers.push(follower);
                            app.nextLink = '';
                            const regex = /(?=https)[^<]+(?=>; rel="next")/gm;
                            const str = response.headers.link;
                            let m;
                            while ((m = regex.exec(str)) !== null) {
                                if (m.index === regex.lastIndex) {
                                    regex.lastIndex++;
                                }
                                m.forEach((match) => {
                                    console.log(match);
                                    app.nextLink = match;
                                });
                            }
                        });
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
        }
    });
</script>
</html>
