<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Laravel\Jetstream\Jetstream;

class TeamController extends Controller
{
    /**
     * Show the team management screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teamId
     * @return \Illuminate\View\View
     */
    public function show(Request $request, $team)
    {
        $team = Jetstream::newTeamModel()->where('uuid',$team)->firstOrFail();

        if (Gate::denies('view', $team)) {
            abort(403);
        }

        if ($team->uuid != $request->user()->currentTeam->uuid) {
            return redirect()->route('teams.show', $request->user()->currentTeam->uuid);
        }

        return view('teams.show', [
            'user' => $request->user(),
            'team' => $team,
        ]);
    }
}
