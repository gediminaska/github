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
//        preg_match('<(.*?)>', $response->getHeader('Link')[0], $matches);
//        dd($matches);
//        $links = $matches[0];
        $followers = json_decode($response->getBody()->getContents());
        return view('followers', compact('login', 'followers'));
    }
}
