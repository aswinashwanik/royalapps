<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Session;
class DashboardController extends Controller
{
    // Show the dashboard page
    public function index()
    {
        // Retrieve the token from the session
        $api_token = session('api_token');

        // If no token, redirect to login
        if (!$api_token) {
            return redirect()->route('login');
        }

        // Initialize the Guzzle HTTP client
        $client = new Client();

        try {
            // Make the API request to fetch the authors list
            $response = $client->get('https://candidate-testing.com/api/v2/authors', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $api_token
                ]
            ]);
 
            $authors = json_decode($response->getBody(), true);
            // $authors = json_decode($response->getBody(), true)['authors'];

  
            $authors = $authors['items']; 

            // Loop through authors and check their book count
            $authors = array_map(function($author) use ($client, $api_token) {
                $id = $author['id'];

                // Get the author's detailed information
                $response_book = $client->get("https://candidate-testing.com/api/v2/authors/{$id}", [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $api_token,
                    ]
                ]);

                $author_book = json_decode($response_book->getBody(), true);

                // Check the count of books and dynamically add the 'delete_btn_active' field
                $delete_btn_active = count($author_book['books']) > 0 ? 'active' : 'disabled';
                $author['delete_btn_active'] = $delete_btn_active;

                return $author;  // Return the modified author data
            }, $authors);

            //   echo '<pre>';print_r($authors);die; 
            // Pass the authors to the view
            return view('dashboard', compact('authors'));


        } catch (\Exception $e) {
            // Handle errors
            \Log::error('Error fetching authors: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Failed to fetch authors. Please try again later.']);
        }
    }


    // public function deleteAuthor($id)
    // {
    //     // Retrieve the token from the session
    //     $api_token = session('api_token');

    //     if (!$api_token) {
    //         return redirect()->route('login');
    //     }

    //     $client = new Client();

    //     try {
    //         // Make the API request to delete the author
    //         $response = $client->delete("https://candidate-testing.com/api/v2/authors/{$id}", [
    //             'headers' => [
    //                 'Authorization' => 'Bearer ' . $api_token,
    //             ]
    //         ]);

    //         // Check if the author was successfully deleted
    //         if ($response->getStatusCode() == 200) {
    //             return redirect()->route('dashboard')->with('success', 'Author deleted successfully');
    //         }

    //         return back()->withErrors(['error' => 'Failed to delete author.']);

    //     } catch (\Exception $e) {
    //         \Log::error('Error deleting author: ' . $e->getMessage());
    //         return back()->withErrors(['error' => 'Failed to delete author. Please try again later.']);
    //     }
    // }

    // public function show($id)
    // {
    //     $api_token = session('api_token');

    //     if (!$api_token) {
    //         return redirect()->route('login');
    //     }

    //     $client = new Client();

    //     try {
    //         // Fetch single author details
    //         $response = $client->get("https://candidate-testing.com/api/v2/authors/{$id}", [
    //             'headers' => [
    //                 'Authorization' => 'Bearer ' . $api_token,
    //             ]
    //         ]);
            
    //         $author = json_decode($response->getBody(), true);

    //         // Fetch the author's books
    //         $responseBooks = $client->get("https://candidate-testing.com/api/v2/authors/{$id}/books", [
    //             'headers' => [
    //                 'Authorization' => 'Bearer ' . $api_token,
    //             ]
    //         ]);

    //         $books = json_decode($responseBooks->getBody(), true);

    //         return view('authors.show', compact('author', 'books'));

    //     } catch (\Exception $e) {
    //         \Log::error('Error fetching author details: ' . $e->getMessage());
    //         return back()->withErrors(['error' => 'Failed to fetch author details.']);
    //     }
    // }

    // public function deleteBook($id)
    // {
    //     $api_token = session('api_token');

    //     if (!$api_token) {
    //         return redirect()->route('login');
    //     }

    //     $client = new Client();

    //     try {
    //         // Delete the book using the API
    //         $response = $client->delete("https://candidate-testing.com/api/v2/books/{$id}", [
    //             'headers' => [
    //                 'Authorization' => 'Bearer ' . $api_token,
    //             ]
    //         ]);

    //         if ($response->getStatusCode() == 200) {
    //             return back()->with('success', 'Book deleted successfully');
    //         }

    //         return back()->withErrors(['error' => 'Failed to delete book.']);

    //     } catch (\Exception $e) {
    //         \Log::error('Error deleting book: ' . $e->getMessage());
    //         return back()->withErrors(['error' => 'Failed to delete book. Please try again later.']);
    //     }
    // }



}


