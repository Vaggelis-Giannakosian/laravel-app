<?php

namespace App\Http\Controllers;

use App\Facades\CounterFacade;
use App\Http\Requests\UpdateUser;
use App\Image;
use App\Contracts\CounterContract;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['show']);
//        $this->middleware('locale');
//        $this->middleware("can:update,user")->only(["update","edit"]);
        $this->authorizeResource(User::class,'user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     */
    public function show(User $user)
    {
        return view('users.show',[
            'user'=>$user,
            'counter' => CounterFacade:: update("user-{$user->id}",['users'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     */
    public function edit(User $user)
    {
//        $this->authorize($user);
        return view('users.edit',['user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     */
    public function update(UpdateUser $request, User $user)
    {
//        $this->authorize($user);
        $validatedData = $request->validated();

        if($request->hasFile('avatar'))
        {
            $path = $request->file('avatar')->store('avatars');

            if($user->thumb)
            {
                Storage::delete($user->thumb->path);
                $user->thumb->path = $path;
                $user->thumb->save();
            }else{
                $user->thumb()->save(
                    Image::make(['path'=>$path])
                );
            }

        }

        $user->fill($validatedData)->update();
        return redirect()
            ->route('users.show',['user'=>$user->id])
            ->withStatus('Profile was updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
