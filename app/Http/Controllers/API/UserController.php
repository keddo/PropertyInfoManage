<?php

namespace App\Http\Controllers\API;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::oldest()->paginate(10);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }
    public function profile()
    {
        return auth('api')->user();
    }
    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();
        $currentPhoto = $user->profile_pic;
        
         $this->validate($request, [
            'name'  => 'required|string|max:30',
            'email' => 'required|string|email|max:30|unique:users,email,'.$user->id,
            'password' => 'sometimes|required|string|min:8'
        ]);
        if($request->profile_pic != $currentPhoto){
            $name = time().'.'.explode('/', explode(':', substr($request->profile_pic, 0, strpos($request->profile_pic, ';')))[1])[1];
            \Image::make($request->profile_pic)->save(public_path('img/profiles/').$name);

            $request->merge(['profile_pic' => $name]);
            $userPhoto = public_path('img/profiles/').$currentPhoto;
           if(file_exists($userPhoto)){
              @unlink($userPhoto);
           }
        }
        if(!empty($request->password)){
            $request->merge(['password' => \Hash::make($request['password'])]);
        }

        $user->update($request->all());

        return ['message' => 'success'];

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
        $employee = User::findOrFail($id);

        $this->validate($request, ['name' => 'required|string|max:30',
                       'email' => 'required|string|max:30|unique:users,email,'.$id,
                       'password' => 'required|string|min:8'
            ]);
       $employee->update($request->all());

       return ['Message' => 'Employee updated'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteUser = User::findOrFail($user->id);

        $deleteUser->delete();
    }
}
