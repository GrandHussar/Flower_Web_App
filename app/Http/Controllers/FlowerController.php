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
    public function index(Request $request)
    {
        $query = Flower::query();

        if ($request->has('category') && $request->category !== 'ALL') {
            $query->where('category', $request->category);
        }

        $flowers = $query->orderBy('created_at', 'desc')->paginate(8);

        return response()->json($flowers);
    }


    /**
     * Display the management page for flowers.
     *
     * @return \Inertia\Response
     */
    public function manage()
    {
        $flowers = Flower::all(); // Fetch all flowers for management
        return inertia('Flowers/Manage', ['flowers' => $flowers]); // Render Inertia Vue page
    }
    /**
     * Show the form for creating a new flower.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return inertia('Flowers/Create'); // ✅ This expects a Vue component at resources/js/Pages/Flowers/Create.vue
    }


    /**
     * Store a newly created flower in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'price' => 'required|numeric',
        'rating' => 'required|integer|min:1|max:5',
        'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'description' => 'nullable|string',
    ]);

    if ($request->hasFile('image_path')) {
        $filename = time() . '_' . $request->file('image_path')->getClientOriginalName();
        $request->file('image_path')->move(public_path('images'), $filename);
        $validated['image_path'] = 'images/' . $filename;

    }

    Flower::create($validated);

    return back()->with('success', 'Flower created catalog successfully.');
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
        return inertia('Flowers/Edit', [
            'flower' => $flower,
        ]);

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
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'price' => 'required|numeric',
        'rating' => 'required|integer|min:1|max:5',
        'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'description' => 'nullable|string',
    ]);

    if ($request->hasFile('image_path')) {
        $filename = time() . '_' . $request->file('image_path')->getClientOriginalName();
        $request->file('image_path')->move(public_path('images'), $filename);
        $validated['image_path'] = 'images/' . $filename;

    }

    $flower->update($validated);

    return back()->with('success', 'Flower edited from catalog successfully.');
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

        return back()->with('success', 'Flower removed from catalog successfully.');
    }
}
