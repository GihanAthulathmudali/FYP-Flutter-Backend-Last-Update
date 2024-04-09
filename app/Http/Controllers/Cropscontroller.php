<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Order;
use App\Models\Crop;
use App\Models\Disease;
use App\Models\LifeCycleImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class Cropscontroller extends Controller
{
    public function cropsstore(Request $request)
    {
        $validatedData = $request->validate([
            'cropName' => 'nullable|string',
            'mainImagePath' => 'nullable|string',
            'subImagePaths' => 'nullable|array',
            'zone' => 'nullable|string',
            'soilType' => 'nullable|string',
            'selectedSeason' => 'nullable|string',
            'selectedWateringCycle' => 'nullable|string',
            'weeklyOption' => 'nullable|string',
            'timeOption' => 'nullable|string',
            'dailyOption' => 'nullable|string',
            'selectedDiseaseList' => 'nullable|array',
            'cropVariety' => 'nullable|string',
            'lifeCycleDescription' => 'nullable|string',
            'lifeCycleImagePaths' => 'nullable|array',
        ]);
        

        // Create a new crop record
        $crop = Crop::create($validatedData);

        return response()->json(['message' => 'Crop record created successfully', 'data' => $crop], 200);
    }


   public function getCropsWithSimilarSoilType(Request $request)
{
    // Validate the request data
    $validatedData = $request->validate([
        'soilType' => 'nullable|string', // Make soilType nullable
    ]);

    // Retrieve all crops if soilType is not provided
    if (empty($validatedData['soilType'])) {
        $similarSoilType = Crop::all();
    } else {
        // Retrieve crops where soil type is similar to the provided value
        $similarSoilType = Crop::where('soilType', 'LIKE', '%' . $validatedData['soilType'] . '%')->get();
    }

    return response()->json(['message' => 'Crop records with similar soil type retrieved successfully', 'data' => $similarSoilType], 200);
}


    public function storedisease(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'diseaseName' => 'required|string',
            'cropName' => 'required|string',
            'description' => 'required|string',
            'solution' => 'required|string',
        ]);

     
        // Create new data entry
        $data = Disease::create([
            'disease_name' => $validatedData['diseaseName'],
            'crop_name' => $validatedData['cropName'],
            'description' => $validatedData['description'],
            'solution' => $validatedData['solution'],
            'image_paths' => $request['images']
        ]);

        // Return response
        return response()->json(['message' => 'Data inserted successfully', 'data' => $data], 200);
    }
    

    public function diseasesgetall()
    {
        // Retrieve all diseases from the database
        $diseases = Disease::all();

        // Return response with the retrieved diseases
        return response()->json(['diseases' => $diseases], 200);
    }
    
    public function diseasesgetiD(Request $request)
    {
        // Retrieve all diseases or a specific disease by ID from the database
        $query = Disease::query();
        
        if ($request->id !== null) {
            $query->where('id', $request->id);
        }

        $diseases = $query->get();

        // Return response with the retrieved diseases
        return response()->json(['diseases' => $diseases], 200);
    }


}
