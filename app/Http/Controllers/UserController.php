<?php

namespace App\Http\Controllers;

use App\Facades\CounterFacade;
use App\Http\Requests\UpdateUser;
use App\Image;
use App\Contracts\CounterContract;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['show','authenticate']);
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



    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function getAuthenticatedUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }
        return response()->json(compact('user'));
    }

}
