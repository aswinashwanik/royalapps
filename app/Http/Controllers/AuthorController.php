<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Session;
use Illuminate\Support\Facades\Log;

class AuthorController extends Controller
{
    public function index()
    {
        $client = new Client();
        echo session('api_token');die;
        $response = $client->get(env('API_URL') . '/authors', [
            'headers' => [
                'Authorization' => 'Bearer ' . session('api_token'),
            ]
        ]);

        $authors = json_decode($response->getBody(), true);
        return view('authors.index', compact('authors'));
    }

    public function create()
    {
        // This will return a view with the form to create a new author
        return view('authors.create');
    }

    public function show($id)
    {
        $client = new Client();
        $response = $client->get("https://candidate-testing.com/api/v2/authors/{$id}", [
            'headers' => [
                'Authorization' => 'Bearer ' . session('api_token'),
            ]
        ]);

        $author = json_decode($response->getBody(), true);
 
        return view('authors.show', compact('author'));
    }

    // public function destroy($id)
    // {
    //     $client = new Client();
    //     $response = $client->get(env('API_URL') . "/authors/{$id}", [
    //         'headers' => [
    //             'Authorization' => 'Bearer ' . session('api_token'),
    //         ]
    //     ]);

    //     $author = json_decode($response->getBody(), true);

    //     // Check if the author has no books
    //     if (count($author['books']) === 0) {
    //         $client->delete(env('API_URL') . "/authors/{$id}", [
    //             'headers' => [
    //                 'Authorization' => 'Bearer ' . session('api_token'),
    //             ]
    //         ]);
    //     }

    //     return redirect()->route('dashboard');
    // }

    public function destroy($authorId)
    {
        // Retrieve the API token from the session
        $api_token = session('api_token');

        if (!$api_token) {
            return redirect()->route('login');
        }

        // Initialize the Guzzle HTTP client
        $client = new Client();

        try {
            // Make the API request to delete the author
            $response = $client->delete('https://candidate-testing.com/api/v2/authors/' . $authorId, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $api_token
                ]
            ]);
 
            // Check if the deletion was successful
            if ($response->getStatusCode() == 200) {
                return redirect()->route('authors.dashboard')->with('message', 'Author deleted successfully.');
            } else {
                return redirect()->route('authors.dashboard')->withErrors('Error deleting author.');
            }

        } catch (\Exception $e) {
            // Log the error and return back with an error message
            \Log::error('Error deleting author: ' . $e->getMessage());
            return redirect()->route('authors.dashboard')->withErrors('Failed to delete author. Please try again later.');

            // return redirect()->route('dashboard')->withErrors('Failed to delete author. Please try again later.');
        }
    }

    

    public function store(Request $request)
{
    // Retrieve the API token from the session
    $api_token = session('api_token');
    
    if (!$api_token) {
        return redirect()->route('login');
    }

    // // Validate the incoming request
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'birthday' => 'required', // Validate the client-side format
        'biography' => 'nullable|string',
        'gender' => 'required|string|in:male,female',
        'place_of_birth' => 'required|string|max:255',
    ]);

    // Get the raw birthday input
    $rawBirthday = $request->input('birthday');

    // Convert the raw input to the required format (Y-m-d\TH:i:s.v\Z)
    $birthday = Carbon::parse($rawBirthday)->format('Y-m-d\TH:i:s.v\Z'); // Format as '2025-02-24T04:56:05.670Z'

    // Prepare the data to be sent to the API
    $data = [
        'first_name' => $request->input('first_name'),
        'last_name' => $request->input('last_name'),
        'birthday' => $request->input('birthday'),  // Use the formatted birthday
        'biography' => $request->input('biography'),
        'gender' => $request->input('gender'),
        'place_of_birth' => $request->input('place_of_birth'),
    ];

    // Initialize the Guzzle HTTP client
    $client = new Client();

    try {
        // Make the API request to add the new author
        $response = $client->post('https://candidate-testing.com/api/v2/authors', [
            'json' => $data,
            'headers' => [
                'Authorization' => 'Bearer ' . $api_token,
                'Content-Type' => 'application/json',
            ]
        ]);

        // Check if the response was successful
        if ($response->getStatusCode() == 200) {
            return redirect()->route('authors.dashboard')->with('success', 'Author added successfully.');
        } else {
            return back()->withErrors(['error' => 'Failed to add author. ' . $response->getBody()]);
        }

    } catch (\Exception $e) {
        // Log the error and return back with an error message
        Log::error('Error adding author: ' . $e->getMessage());
        return back()->withErrors(['error' => 'Failed to add author. Please try again later.']);
    }
}

    
}
