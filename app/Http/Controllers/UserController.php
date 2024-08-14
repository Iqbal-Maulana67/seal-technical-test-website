<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function api_view()
    {
        $users = User::all();

        foreach($users as $user)
        {
            $user->profile = Storage::url('public/img/profile/' . $user->profile);
        }
        return response()->json($users);
    }

    public function api_create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:users,email',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'profile' => 'required|file|mimes:jpeg,png,jpg',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Beberapa input kosong atau invalid'], 422);
        }

        $file = $request->file('profile');

        $filename = 'attachments_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Ensure the directory exists
        if (!File::exists(storage_path('app/public/img/profile'))) {
            File::makeDirectory(storage_path('app/public/img/profile'), 0777, true, true);
        }
        // Store the file
        $path = 'public/img/profile';
        $file->storeAs($path, $filename);

        $user = new User();

        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = Hash::make($request->input('password'));
        $user->profile = $filename;
        $user->save();

        return response()->json(['message' => 'User berhasil ditambahkan', 'user' => $user], 200);
    }

    public function api_update(User $user, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'sometimes|required|email|max:255|unique:users,email,' . $user->id,
            'name' => 'sometimes|required|string|max:255',
            'password' => 'sometimes|required|string|min:8',
            'profile' => 'sometimes|file|mimes:jpeg,png,jpg',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Beberapa input kosong atau invalid'], 422);
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        if ($request->hasFile('profile')) {
            // Delete old profile image
            $oldProfile = storage_path('app/public/img/profile/' . $user->profile);
            if (File::exists($oldProfile)) {
                File::delete($oldProfile);
            }

            // Store new profile image
            $file = $request->file('profile');
            $filename = 'attachments_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = 'public/img/profile';
            $file->storeAs($path, $filename);

            // Update profile path
            $user->profile = $filename;
        }

        $user->save();

        return response()->json(['message' => 'User berhasil diubah', 'user' => $user], 200);
    }

    public function api_delete(User $user)
    {
        if ($user->profile && Storage::exists('public/img/profile/' . $user->attachment)) {
            Storage::delete('public/img/profile/' . $user->attachment);
        }

        $user->delete();
        return response()->json(['message' => 'User berhasil dihapus'], 200);
    }
}
