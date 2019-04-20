<?php

namespace App\Http\Controllers;

use App\Trip;
use App\Http\Resources\Trip as TripResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class TripController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Trip::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $trips = Trip::all()->filter(function ($value, $key) use ($user) {
            return $user->can('view', $value);
        });

        return TripResource::collection($trips);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required|string|max:64',
            'description' => 'bail|string|max:2048',
        ]);

        $user = Auth::user();

        $trip = new Trip();

        $trip->name = $request->input('name');
        $trip->description = $request->input('description');

        $user->trips()->save($trip);

        return new TripResource($trip);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function show(Trip $trip)
    {
        return new TripResource($trip);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trip $trip)
    {
        $request->validate([
            'name' => 'bail|string|max:64',
            'description' => 'bail|string|max:2048',
        ]);

        if ($request->filled('name')) {
            $trip->name = $request->input('name');
        }

        if ($request->filled('description')) {
            $trip->description = $request->input('description');
        }

        $trip->save();

        return new TripResource($trip);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trip $trip)
    {
        $trip->delete();
        return Response::make('', 204);
    }
}
