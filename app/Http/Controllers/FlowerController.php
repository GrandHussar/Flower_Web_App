<?php

namespace App\Http\Controllers;

use App\Models\Flower;
use Illuminate\Http\Request;

class FlowerController extends Controller
{
    /**
     * Display a listing of all flowers in the catalog.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $flowers = Flower::paginate(8);
        return response()->json($flowers); // Return flowers as JSON
    }
    
    /**
     * Show the form for creating a new flower.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('flowers.create'); // Display form for creating a flower
    }

    /**
     * Store a newly created flower in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric',
            'rating' => 'required|integer|min:1|max:5',
            'image_path' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Flower::create($request->all());

        return redirect()->route('flowers.index')->with('success', 'Flower added to catalog successfully.');
    }

    /**
     * Display the specified flower.
     *
     * @param  \App\Models\Flower  $flower
     * @return \Illuminate\View\View
     */
    public function show(Flower $flower)
    {
        return view('flowers.show', compact('flower')); // Show a single flower
    }

    /**
     * Show the form for editing the specified flower.
     *
     * @param  \App\Models\Flower  $flower
     * @return \Illuminate\View\View
     */
    public function edit(Flower $flower)
    {
        return view('flowers.edit', compact('flower')); // Display form for editing a flower
    }

    /**
     * Update the specified flower in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Flower  $flower
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Flower $flower)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric',
            'rating' => 'required|integer|min:1|max:5',
            'image_path' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $flower->update($request->all());

        return redirect()->route('flowers.index')->with('success', 'Flower updated successfully.');
    }

    /**
     * Remove the specified flower from the database.
     *
     * @param  \App\Models\Flower  $flower
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Flower $flower)
    {
        $flower->delete();

        return redirect()->route('flowers.index')->with('success', 'Flower removed from catalog successfully.');
    }
}
