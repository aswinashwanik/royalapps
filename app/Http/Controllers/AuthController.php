<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Session;
use GuzzleHttp\Exception\RequestException;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');  // Display login form
    }

    public function authenticate(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Initialize the Guzzle HTTP client
        $client = new Client();
        
        try {
            // Make the API request to get the token
            $response = $client->post('https://candidate-testing.com/api/v2/token', [
                'json' => [
                    'email' => $request->input('email'),
                    'password' => $request->input('password')
                ]
            ]);

            // Decode the response body to get the data
            $data = json_decode($response->getBody(), true);
//             echo '<pre>';
// print_r($data);die;
            // Check if the token exists in the response
            if (isset($data['token_key'])) {
                // Store the token in the session
                session(['api_token' => $data['token_key']]);

                // Optionally, store the user's first and last name as well
                session(['user' => $data['user']]);
                return redirect()->route('authors.dashboard'); 
                // Redirect the user to the dashboard
                return redirect()->route('dashboard');
                
            } else {
                // Handle case where token is not returned
                return back()->withErrors(['email' => 'Invalid login credentials']);
            }

        } catch (RequestException $e) {
            // Log the error message
            \Log::error('Authentication error: ' . $e->getMessage());

            // Return an error message to the user
            return back()->withErrors(['email' => 'Failed to authenticate. Please try again later.']);
        }
    }

    public function logout()
    {
        session()->forget(['api_token', 'user']);
        return redirect()->route('login');
    }
}
