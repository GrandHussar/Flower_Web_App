<?php
namespace App\Http\Controllers;
use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarouselController extends Controller
{
    public function index()
    {
        return response()->json(Carousel::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
            'alt' => 'nullable|string',
        ]);

        $path = $request->file('image')->store('images', 'public');

        $carousel = Carousel::create([
            'image_path' => $path,
            'alt' => $request->alt,
        ]);

        return back()->with('success', 'Carousel image added.');
    }

    public function destroy($id)
    {
        $carousel = Carousel::findOrFail($id);
        Storage::disk('public')->delete($carousel->image_path);
        $carousel->delete();

        return back()->with('success', 'Carousel image deleted.');
    }
}
