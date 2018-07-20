<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $client = new GuzzleHttp\Client();

        $response = $client->request('GET', 'https://api.github.com/search/users', ['query' => [
            'q' => $request->username,
            'followers' => 1,
        ]]);
        $contents = json_decode($response->getBody()->getContents());
        $results = $contents->items;
        return view('results', compact('results'));
    }

    public function listFollowers($login)
    {
        $client = new GuzzleHttp\Client();
        $response = $client->request('GET', 'https://api.github.com/users/' . $login . '/followers');
        $followers = json_decode($response->getBody()->getContents());
        $secondPageUrl = null;
        if($response->hasHeader('Link')) {
            $paginationLinks = $response->getHeaders()['Link'][0];
            preg_match('/(?=https)[^<]+(?=>; rel="next")/m', $paginationLinks, $secondPageUrl);
            $secondPageUrl = $secondPageUrl[0];
        }
        $response = $client->request('GET', 'https://api.github.com/users/' . $login);
        $numberOfFollowers = json_decode($response->getBody()->getContents())->followers;
        return view('followers', compact('login', 'followers', 'secondPageUrl', 'numberOfFollowers'));
    }
}
