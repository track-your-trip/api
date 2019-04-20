<?php

namespace App\Http\Controllers;

use App\Location;
use App\Trip;
use App\Http\Resources\Location as LocationResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class LocationController extends Controller
{

    public function __construct()
    {
        // Users who can't view the trip also can't view the location
        $this->middleware('can:view,trip', [
            'only' => [
                'index',
                'show'
            ],
        ]);

        // Users who can't update the trip also can't add or update a location
        $this->middleware('can:update,trip', [
            'only' => [
                'store',
                'update',
                'destroy',
            ],
        ]);

        $this->authorizeResource(Location::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function index(Trip $trip)
    {
        $locations = $trip
                        ->locations()
                        ->orderBy('beginn', 'asc')
                        ->get();

        return LocationResource::collection($locations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Trip  $trip
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Trip $trip)
    {
        $request->validate([
            'name' => 'bail|required|string|max:64',
            'description' => 'bail|string|max:2048',
            'beginn' => 'bail|required|date',
            'end' => 'bail|required|date',
            'lat' => 'bail|required|numeric|between:-90,90',
            'lng' => 'bail|required|numeric|between:-180,180',
        ]);

        $location = new Location();

        $location->name = $request->input('name');
        $location->description = $request->input('description');
        $location->beginn = $request->input('beginn');
        $location->end = $request->input('end');
        $location->lat = $request->input('lat');
        $location->lng = $request->input('lng');

        $trip->locations()->save($location);

        return new LocationResource($location);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Trip  $trip
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Trip $trip, Location $location)
    {
        return new LocationResource($location);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Trip  $trip
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trip $trip, Location $location)
    {
        $request->validate([
            'name' => 'bail|string|max:64',
            'description' => 'bail|string|max:2048',
            'beginn' => 'bail|date',
            'end' => 'bail|date',
            'lat' => 'bail|numeric|between:-90,90',
            'lng' => 'bail|numeric|between:-180,180',
        ]);

        if ($request->filled('name')) {
            $location->name = $request->input('name');
        }

        if ($request->filled('description')) {
            $location->description = $request->input('description');
        }

        if ($request->filled('beginn')) {
            $location->beginn = $request->input('beginn');
        }

        if ($request->filled('end')) {
            $location->end = $request->input('end');
        }

        if ($request->filled('lat')) {
            $location->lat = $request->input('lat');
        }

        if ($request->filled('lng')) {
            $location->lng = $request->input('lng');
        }

        $location->save();

        return new LocationResource($location);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Trip  $trip
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trip $trip, Location $location)
    {
        $location->delete();
        return Response::make('', 204);
    }
}
