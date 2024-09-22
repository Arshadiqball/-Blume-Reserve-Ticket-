<?php

namespace App\Http\Controllers;

use App\Models\BRT;
use App\Events\BRTUpdated;
use App\Events\PublicMessageEvent;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class BRTController extends Controller
{
    public function index() {
        $brts = auth()->user()->brts;

        if ($brts->isEmpty()) {
            return response()->json(['error' => 'No BRT records found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($brts, Response::HTTP_OK);
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'reserved_amount' => 'required|numeric|min:0',
        ]);

        $brt = BRT::create([
            'user_id' => auth()->id(),
            'brt_code' => uniqid('BRT-'),
            'reserved_amount' => $validatedData['reserved_amount'],
        ]);
        
        event(new BRTUpdated($brt));

        return response()->json($brt, Response::HTTP_CREATED);
    }

    public function show($id) {
        try {
            $brt = BRT::findOrFail($id);
            return response()->json($brt, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'BRT not found'], Response::HTTP_NOT_FOUND);
        }
    }

    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'reserved_amount' => 'sometimes|required|numeric|min:0',
            'status' => 'sometimes|required|in:active,expired',
        ]);

        try {
            $brt = BRT::findOrFail($id);
            $brt->update($validatedData);

            broadcast(new BRTUpdated($brt));

            return response()->json($brt, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'BRT not found'], Response::HTTP_NOT_FOUND);
        }
    }

    public function destroy($id) {
        try {
            $brt = BRT::findOrFail($id);
            $brt->delete();
            
            broadcast(new BRTUpdated($brt));

            return response()->json(['message' => 'BRT deleted'], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'BRT not found'], Response::HTTP_NOT_FOUND);
        }
    }
}
