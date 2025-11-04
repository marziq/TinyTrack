<?php

namespace App\Http\Controllers;

use App\Models\FavoriteTip;
use Illuminate\Http\Request;

class FavoriteTipController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'tip_id' => 'required|string',
            'title' => 'required|string',
            'content' => 'required|string',
            'category' => 'required|string',
        ]);

        try {
            $user = auth()->user();

            // Check if tip is already favorited
            $existingFavorite = $user->favoriteTips()->where('tip_id', $request->tip_id)->first();

            if ($existingFavorite) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tip is already in favorites'
                ]);
            }

            // Create new favorite tip with rich content
            $favoriteTip = $user->favoriteTips()->create([
                'tip_id' => $request->tip_id,
                'title' => $request->title,
                'content' => $request->content,
                'category' => $request->category,
                'rich_content' => $request->input('rich_content', $request->content), // Use rich content if provided, fallback to plain
                'image_url' => $request->input('image_url'),
                'video_url' => $request->input('video_url'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tip saved to favorites successfully',
                'data' => $favoriteTip
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving tip to favorites'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $favorite = FavoriteTip::where('user_id', auth()->id())
                ->where('id', $id)
                ->firstOrFail();

            $favorite->delete();

            return response()->json([
                'success' => true,
                'message' => 'Tip removed from favorites'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error removing tip from favorites'
            ], 500);
        }
    }

    public function checkFavorite($tipId)
    {
        try {
            $favorite = FavoriteTip::where('user_id', auth()->id())
                ->where('tip_id', $tipId)
                ->first();

            if ($favorite) {
                return response()->json([
                    'success' => true,
                    'isFavorite' => true,
                    'favoriteId' => $favorite->id
                ]);
            }

            return response()->json([
                'success' => true,
                'isFavorite' => false,
                'favoriteId' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'isFavorite' => false,
                'favoriteId' => null
            ]);
        }
    }
}
