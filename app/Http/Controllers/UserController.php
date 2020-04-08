<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Permissions;
use App\UserPermissions;

class UserController extends Controller
{
   private function getPermissions($granted_permissions = NULL){
     $context = array();
     $categories = Permissions::Categories()->get();
     foreach($categories as $category){
       $rows = Permissions::FilterByCategory($category->category)->get();
       $arr = array();
       foreach($rows as $row){
         if($granted_permissions != NULL){
           $checked = 0;

           foreach($granted_permissions as $granted_permission){
             if($row->id == $granted_permission['permission_id']){
               $checked = 1;
               break;
             }
           }

           array_push($arr,['permission_id' => $row->id,'key' => $row->key,'checked' => $checked]);
         }else{
           array_push($arr,['permission_id' => $row->id,'key' => $row->key]);
         }

       }
       $context[$category->category] = $arr;
     }
     return $context;
   }
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        return view('users.index', ['users' => $model->paginate(15)]);
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $permissions = $this->getPermissions();

        return view('users.create')->with([
          'permissions' => $permissions,
        ]);
    }

    /**
     * Store a newly created user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request, User $model)
    {

        $user = $model->create($request->merge(['password' => Hash::make($request->get('password'))])->all());

        $user_id = $user->id;

        $granted_permissions = $request->granted_permissions;
        foreach($granted_permissions as $permission_id){
          UserPermissions::create([
            'user_id' => $user_id,
            'permission_id' => $permission_id,
          ]);
        }

        return redirect()->route('user.index')->withStatus(__('User successfully created.'));
    }

    /**
     * Show the form for editing the specified user
     *
     * @param  \App\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        $granted_permissions = UserPermissions::select('permission_id')->where('user_id','=',$user->id)->get()->toArray();
        $permissions = $this->getPermissions($granted_permissions);

        return view('users.edit')->with([
          'user' => $user,
          'permissions' => $permissions,
        ]);
    }

    /**
     * Update the specified user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User  $user)
    {
        $user->update(
            $request->merge(['password' => Hash::make($request->get('password'))])
                ->except([$request->get('password') ? '' : 'password']
        ));

        $user_id = $user->id;
        $deleteOld = UserPermissions::where('user_id','=',$user_id)->delete();
        
        $granted_permissions = $request->granted_permissions;
        foreach($granted_permissions as $permission_id){
          UserPermissions::create([
            'user_id' => $user_id,
            'permission_id' => $permission_id,
          ]);
        }
        return redirect()->route('user.index')->withStatus(__('User successfully updated.'));
    }

    /**
     * Remove the specified user from storage
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User  $user)
    {
        $userPermissions = UserPermissions::where('user_id','=',$user->id)->get();
        foreach($userPermissions as $userPermission){
          $userPermission->delete();
        }
        $user->delete();

        return redirect()->route('user.index')->withStatus(__('User successfully deleted.'));
    }
}
