<?php

namespace App\Http\Controllers;

use App\Models\MatchGame;
use App\Http\Requests\StoreMatchhRequest;
use App\Http\Requests\UpdateMatchhRequest;
use Illuminate\Support\Facades\DB;

class MatchGameController extends Controller
{



    public function endmatch($matchid){
        $match=MatchGame::with('players')->findOrFail($matchid);

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
    public function show(MatchGame $matchGame)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MatchGame $matchGame)
    {
        //
    }

    /**
     * Update the specified resource in storage.
 

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MatchGame $matchGame)
    {
        //
    }
}
