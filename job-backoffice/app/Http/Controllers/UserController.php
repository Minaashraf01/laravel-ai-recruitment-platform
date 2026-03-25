<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $query=User::latest();

        // Archive
        if(request()->has('archived') && request()->get('archived') == 'true'){
            $query->onlyTrashed();
            }
            
            $user = Auth::user();
        $users = $query->paginate(10)->onEachSide(1);

        return view ('User.index', compact('users', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('User.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return redirect()->route('User.index')
                ->withErrors('You cannot edit an admin user.');
        }
        return view('User.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return redirect()->route('User.index')
                ->withErrors('You cannot update an admin user.');
        }

        $validated = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('User.index')
            ->with('success', 'Password updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return redirect()->route('User.index')
                ->withErrors('You cannot archive an admin user.');
        }

        $user->delete();

        return redirect()->route('User.index')->with('success', 'User archived successfully.');
    }

    /**
     * Restore the specified resource from storage.
     */
     public function restore(string $id)
    {
        $user = User::withTrashed()->findOrFail($id);

        // ✅ منع استرجاع admin (لو اتأرشف سابقًا)
        if ($user->role === 'admin') {
            return redirect()->route('User.index', ['archived' => 'true'])
                ->withErrors('You cannot restore an admin user.');
        }

        $user->restore();

        return redirect()->route('User.index')->with('success', 'User restored successfully.');
    }
}
