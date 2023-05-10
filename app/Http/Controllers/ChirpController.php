<?php

namespace App\Http\Controllers;

use App\Models\chirp;
use Illuminate\Http\Request;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('chirps.index',[
            'chirps'=> Chirp::with('user')->latest()->get(),
        ]);
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
    public function store(Request $request)
    {
        $validated=$request->validate([
            "message"=>'required|string|max:255'
        ]);

        $request->user()->chirps()->create($validated);

        return redirect(route('chirps.index'));

    }

    /**
     * Display the specified resource.
     */
    public function show(chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(chirp $chirp)
    {
        $this->authorize('update',$chirp);

        return view('chirps.edit',[
            'chirp'=>$chirp,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, chirp $chirp)
    {
        $this->authorize('update',$chirp);

        $validated= $request->validate([
            'messsage'=> 'required|string|max:255',
        ]);

       $chirp-> update($validated);

       return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(chirp $chirp)
    {
    $this->authorize('delete',$chirp);

    $chirp->delete();

    return redirect(route('chirps.index'));
    }
}
