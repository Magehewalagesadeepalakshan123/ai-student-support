<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    // ========================================
    // STUDENTS
    // ========================================

    public function students()
    {
        $students = User::where('role', 'student')
            ->latest()
            ->paginate(10);

        return view(
            'admin.students',
            compact('students')
        );
    }


    // ========================================
    // STAFF
    // ========================================

    public function staff()
    {
        $staff = User::where('role', 'staff')
            ->latest()
            ->paginate(10);

        return view(
            'admin.staff',
            compact('staff')
        );
    }


    // ========================================
    // CREATE STAFF PAGE
    // ========================================

    public function createStaff()
    {
        return view('admin.create-staff');
    }


    // ========================================
    // SAVE STAFF
    // ========================================

    public function storeStaff(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email'
            ],

            'password' => [
                'required',
                'confirmed',
                'min:8'
            ],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make(
                $validated['password']
            ),
            'role' => 'staff',
            'status' => true,
        ]);

        return redirect()
            ->route('admin.staff')
            ->with(
                'success',
                'Staff account created successfully.'
            );
    }


    // ========================================
    // EDIT USER PAGE
    // ========================================

    public function edit(User $user)
    {
        if ($user->role === 'admin') {
            abort(403, 'Admin accounts cannot be edited here.');
        }

        return view(
            'admin.edit-user',
            compact('user')
        );
    }


    // ========================================
    // UPDATE USER
    // ========================================

    public function update(
        Request $request,
        User $user
    ) {
        if ($user->role === 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')
                    ->ignore($user->id),
            ],

            'role' => [
                'required',
                'in:student,staff'
            ],

            'status' => [
                'required',
                'boolean'
            ],
        ]);

        $user->update($validated);

        if ($user->role === 'staff') {
            return redirect()
                ->route('admin.staff')
                ->with(
                    'success',
                    'User updated successfully.'
                );
        }

        return redirect()
            ->route('admin.students')
            ->with(
                'success',
                'User updated successfully.'
            );
    }


    // ========================================
    // ACTIVATE / DEACTIVATE
    // ========================================

    public function toggleStatus(User $user)
    {
        if ($user->role === 'admin') {
            abort(403);
        }

        $user->update([
            'status' => !$user->status,
        ]);

        return back()->with(
            'success',
            'Account status updated successfully.'
        );
    }


    // ========================================
    // DELETE USER
    // ========================================

    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            abort(403);
        }

        if ($user->id === auth()->id()) {
            return back()->with(
                'error',
                'You cannot delete your own account.'
            );
        }

        $user->delete();

        return back()->with(
            'success',
            'User deleted successfully.'
        );
    }
}