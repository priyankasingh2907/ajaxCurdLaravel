<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class AcountController extends Controller
{
    public function index()
    {
        $countries = DB::table('countries')->OrderBy('name', 'ASC')->get();
        return view('users.create', ['countries' => $countries]);
    }
    public function fetchStates($country_id = null)
    {
        // echo "ghjk";
        // dd($country_id);
        $states = DB::table('states')->where('country_id', $country_id)->get();
        //    dd($states);
        return response()->json([
            'status' => 1,
            'states' => $states,
        ]);
    }
    public function fetchCities($state_id = null)
    {

        $cities = DB::table('cities')->where('state_id', $state_id)->get();

        return response()->json([
            'status' => 1,
            'cities' => $cities,
        ]);
    }
    public function save(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
        ]);
        if ($validator->passes()) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->country = $request->country;
            $user->state = $request->state;
            $user->city = $request->city;
            $user->save();
            Session()->flash('success', 'User added successfully. ');
            return response()->json(
                [
                    'status' => 1,
                ]

            );
        } else {
            return response()->json(
                [
                    'status' => 0,
                    'errors' => $validator->errors(),

                ]

            );
        }
    }
    public function list()
    {
        $users = DB::table('users')->get();

        return View('users.list', ['users' => $users]);
    }
    public function edit($id, Request $request)
    {
        $users = DB::table('users')->where('id', $id)->first();
        // dd($users);
        $countries = DB::table('countries')->orderBy('name','ASC')->get();
        
        $states = DB::table('states')->where('country_id',$users->country)->get();
        // dd($states);


        $cities = DB::table('cities')->where('state_id', $users->state)->get();

       

        return View('users.edit', ['users' => $users,'countries'=>$countries ,'states'=>$states,'cities'=>$cities]);
    }
    public function update($id, Request $request)
    {

        $user = User::find($id);
        // dd($user);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
        ]);
        if ($validator->passes()) {
         
            $user->name = $request->name;
          
            $user->email = $request->email;
            $user->country = $request->country;
            $user->state = $request->state;
            $user->city = $request->city;
            $user->save();
           
            Session()->flash('success', 'User updated successfully. ');
            return response()->json(
                [
                    'status' => 1,
                    'data'=>$user,
                ]

            );
        } else {
            return response()->json(
                [
                    'status' => 0,
                    'errors' => $validator->errors(),

                ]

            );
        }
    }
    public function delete($id)
    {
        $users = DB::table('users')->where('id', $id)->first();
        Session()->flash('success', 'User deleted successfully. ');
        return View('users.list', ['users' => $users]);
    }
}
