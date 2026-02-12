<?php

namespace App\Http\Controllers;

use App\Models\Matchh;
use App\Http\Requests\StoreMatchhRequest;
use App\Http\Requests\UpdateMatchhRequest;
use Illuminate\Support\Facades\DB;

class MatchhController extends Controller
{



    public function endmatch($matchid){
        $match=Matchh::with('players')->findOrFail($matchid);

        DB::transaction(function() use ($match) {
            foreach($match->players as $player) {
                $user = $player; 
                $pivotData = $player->pivot;

                
                $user->gold += $pivotData->gold_gained;
                $user->gems += $pivotData->gems_gained;
                $user->experience += $pivotData->experience_gained;

                if($pivotData->rank == 1) {
                    $user->wins += 1;
                } else {
                    $user->loses += 1;
                }

                $user->save();
            }
            
        });
     
    }







    
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMatchhRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Matchh $matchh)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Matchh $matchh)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMatchhRequest $request, Matchh $matchh)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Matchh $matchh)
    {
        //
    }
}
