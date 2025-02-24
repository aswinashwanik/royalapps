<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Session;

class BookController extends Controller
{
     // Show form to add a new book
    public function create()
    {
        $api_token = session('api_token');
        
        if (!$api_token) {
            return redirect()->route('login');
        }

        // Fetch authors list from the API
        $client = new Client();
        try {
            $response = $client->get('https://candidate-testing.com/api/v2/authors', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $api_token,
                ]
            ]);
            $authors = json_decode($response->getBody(), true)['items'];

            // Show the form to create a new book
            return view('books.create', compact('authors'));
        } catch (\Exception $e) {
            \Log::error('Error fetching authors: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to fetch authors.']);
        }
    }

    public function store(Request $request)
    {
        $api_token = session('api_token');
        
        if (!$api_token) {
            return redirect()->route('login');
        }
    
        // Temporarily skipping validation (remove this later)
        // $request->validate([
        //     'title' => 'required|string|max:255',
        //     'author_id' => 'required|exists:authors,id',
        //     'release_date' => 'required|date_format:Y-m-d\TH:i:s.v\Z',
        //     'description' => 'nullable|string',
        //     'isbn' => 'nullable|string',
        //     'format' => 'nullable|string',
        //     'number_of_pages' => 'nullable|integer',
        // ]);
    
        // Initialize the Guzzle HTTP client
        $client = new Client();
        try {
            // Prepare the API request data to match the expected structure (JSON 1 format)
            $data = [
                'author' => [
                    'id' => (int) $request->input('author_id'), // Ensure author ID is an integer
                ],
                'title' => $request->input('title'),
                'release_date' => $request->input('release_date'), // Ensure the correct ISO 8601 format
                'description' => $request->input('description', ''),
                'isbn' => $request->input('isbn', ''),
                'format' => $request->input('format', ''),
                'number_of_pages' => (int) $request->input('number_of_pages', 1), // Ensure number_of_pages is an integer
            ];
        
            // Output the data as JSON for debugging purposes
            // echo '<pre>'; print_r(json_encode($data)); die;
        
            // Make the API request to add the new book
            $response = $client->post('https://candidate-testing.com/api/v2/books', [
                'json' => $data,
                'headers' => [
                    'Authorization' => 'Bearer ' . $api_token,
                    'Content-Type' => 'application/json',
                ]
            ]);
        
            // Check if the response was successful
            $responseData = json_decode($response->getBody(), true);
        
            // If the book was successfully added
            if ($response->getStatusCode() == 200) {
                return redirect()->route('authors.dashboard')->with('success', 'Book added successfully.');
            } else {
                // If there was an error, return the error message
                return back()->withErrors(['error' => 'Failed to add book. ' . $responseData['message']]);
            }
        } catch (\Exception $e) {
            // Log the error and return back with a generic error message
            \Log::error('Error adding book: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to add book. Please try again later.']);
        }
    }
    

    // Show books for a specific author
    public function show($authorId)
    {
        $api_token = session('api_token');
        
        if (!$api_token) {
            return redirect()->route('login');
        }

        $client = new Client();

        try {
            $response = $client->get('https://candidate-testing.com/api/v2/authors/' . $authorId, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $api_token,
                ]
            ]);
            $author = json_decode($response->getBody(), true);

            return view('books.show', compact('author'));
        } catch (\Exception $e) {
            \Log::error('Error fetching author books: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to fetch books for this author.']);
        }
    }

    // Delete a book
    public function destroy($bookId)
    {
        $api_token = session('api_token');
        
        if (!$api_token) {
            return redirect()->route('login');
        }

        $client = new Client();

        try {
            $response = $client->delete('https://candidate-testing.com/api/v2/books/' . $bookId, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $api_token,
                ]
            ]);

            return back()->with('success', 'Book deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Error deleting book: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to delete book.']);
        }
    }
}
