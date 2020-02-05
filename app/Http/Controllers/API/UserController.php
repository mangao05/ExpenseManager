<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Roles;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::where('id', '!=', 1)->with('role')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required'
        ]);

        $request['role_id'] = $request->role;
        User::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'role' => 'required',
            'email' => 'email|required'
        ]);

        if($request->password != null || !empty($request->password) || $request->password != ""){
            $request['password'] = \Hash::make($request->password);
        }
        
        $request['role_id'] = $request->role;

        User::find($id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if($user->role_id == 1){
            return 1;
        }

        $user->delete();
    }

    public function getRole($id){
        return User::find($id);
    }

    public function changePassword(Request $request){
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|confirmed'
        ]);
        $user = User::find($request->id);
        if(\Hash::check($request->old_password, $user->password)){
            $user->password = \Hash::make($request->password);
            $user->save();
            return;
        }
        return 1;
       
    }
}
