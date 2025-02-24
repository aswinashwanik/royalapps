<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;

class AddAuthor extends Command
{
    protected $signature = 'author:add {first_name} {last_name} {birthday} {biography} {place_of_birth}';
    protected $description = 'Add a new author';

    public function handle()
    {
        // Initialize the HTTP client
        $client = new Client();

        try {
            // Prepare the request to add the author
            $response = $client->post(env('API_URL') . '/authors', [
                'json' => [
                    'first_name' => $this->argument('first_name'),
                    'last_name' => $this->argument('last_name'),
                    'birthday' => $this->argument('birthday'),
                    'biography' => $this->argument('biography'),
                    'place_of_birth' => $this->argument('place_of_birth'),
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . session('api_token'), // Ensure you have the correct token
                    'Content-Type' => 'application/json',
                ]
            ]);

            // Handle response
            $data = json_decode($response->getBody(), true);
            $this->info('Using API Token: ' . session('api_token'));

            $this->info('Authors fetched: ' . print_r($data, true));
            
            $this->info('Author added successfully: ' . $data['first_name'] . ' ' . $data['last_name']);

        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $response = $e->getResponse();
            $this->error('Error adding author: ' . $response->getBody()->getContents());
        }
    }
}
