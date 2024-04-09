<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Url;

class UrlController extends Controller
{
    public function store(Request $request)
    {
        $inputUrl = $request->input('url');

        // Check if the URL already exists in the database
        $url = Url::where('id', 1)->first();

        if ($url) {
            // If the URL exists, update its data
            $url->update(['url' => $inputUrl]);
            return "URL updated successfully";
        } else {
            // If the URL doesn't exist, create a new record
            $url = new Url();
            $url->url = $inputUrl;
            $url->save();
            return "URL stored successfully";
        }
    }
    
    
      public function get()
    {
        // Retrieve all URLs from the database
        $urls = Url::all();

        // Return the URLs to the view or as an API response
        return $urls;
    }
}
