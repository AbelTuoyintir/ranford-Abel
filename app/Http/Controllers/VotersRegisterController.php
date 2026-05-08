<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class VotersRegisterController extends Controller
{
     public function index(Request $request){
        $intUsers = User::where('role', 'voter')
                ->where(function($query) {
                    $query->where('email', 'like', '%@stu.ucc.edu.gh%')
                          ->orWhere('email', 'like', '%.ucc.edu.gh%');
                })->count();
        $norUsers = User::where('role', 'voter')
            ->where(function($query) {
                $query->where('email', 'like', '%@gmail.com')
                ->orWhere('email', 'like', '%@icloud.com');
                })->count();

        $emptyEmailUsers = User::where('role', 'voter')
            ->where('email', '')
            ->count();

            $search = $request->input('search');

            $users = User::where('role', 'voter')
                ->when($search, function($query) use ($search) {
                    return $query->where(function($q) use ($search) {
                        $q->where('school_id', $search)
                          ->orWhere('email', $search);
                    });
                })
                ->get();

        if ($request->ajax()) {
            return response()->json([
                'users' => $users,
                'norUsers' => $norUsers,
                'intUsers' => $intUsers,
                'emptyEmailUsers' => $emptyEmailUsers
            ]);
        }

        return view("livewire.votersRegister", [
            "users" => $users,
            "norUsers" => $norUsers,
            "intUsers" => $intUsers,
            "emptyEmailUsers" => $emptyEmailUsers
        ]);
   }
}
