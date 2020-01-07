<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Institution;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Exceptions\APIException;
use Exception;

class UserController extends Controller
{
    private $limit;

    public function getAllUsers(){
        try{
            DB::beginTransaction();

            $users = User::all();

            DB::commit();
        } catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }

        return response()->json($users);
    }

    public function getOneUser($id){
        try{
            DB::beginTransaction();

            $user = User::find($id);

            if(!$user){
                throw new APIException('User does not exists.', APIException::NOT_FOUND);
            }

            DB::commit();
        } catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }

        return response()->json($user);
    }

    public function createUser(Request $request){
        try {
            DB::beginTransaction();

            $user = $this->addOrUpdateUser($request);

            $user->save();
            $roleIds = $this->getRoleIds($request->roles);
            $user->roles()->sync($roleIds);
            DB::commit();
        } catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }

        return response()->json(User::find($user->id), 200);
    }

    public function updateUser($id, Request $request){

        try{
            DB::beginTransaction();

            $user = User::find($id);

            if(!$user){
                throw new APIException('User does not exists.', APIException::NOT_FOUND);
            }

            $user = $this->addOrUpdateUser($request, $user);

            $user->save();
            $roleIds = $this->getRoleIds($request->roles);
            $user->roles()->sync($roleIds);
            DB::commit();
        } catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }

        return response()->json($user->refresh(), 200);
    }

    public function deleteUser($id){
        try{
            DB::beginTransaction();

            $user = User::find($id);

            if(!$user){
                throw new APIException('User does not exists.', APIException::NOT_FOUND);
            }

            $user->delete();

            DB::commit();

        } catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
        return response()->json();
    }

    public function autocomplete(Request $request){
        $this->validate($request, [
            'input' => 'required|string|min:1',
            'limit' => 'numeric|min:5|max:100'
        ]);

        $input = $request->input('input');
        $limit = $request->input('limit');
        if(!empty($limit)){
            $this->limit = (int)$limit;
        }

        $users = User::where('name', 'ilike', '%' . $input . '%')
            ->orWhere('email', 'ilike', '%' . $input . '%')
            ->limit($this->limit)
            ->get();

        return response()->json($users);
    }

    //=====================================================

    private function getRoleIds($roles = []){

        $roleIds = [];
        foreach($roles as $role){
            $roleIds[] = $role['id'];
        }

        return $roleIds;
    }

    private function addOrUpdateUser(Request $request, $user = null){
        try {
            if (!$user) {
                $user = new User();
                $this->validate($request, [
                    'email' => 'required|max:255|email|unique:users,email'
                ]);
            } else {
                $this->validate($request, [
                    'email' => 'required|max:255|email|unique:users,email,' . $user->id
                ]);
            }

            $this->validate($request, [
                'name'              => 'required|max:255',
                'password'          => 'nullable|string|min:5|max:72',
                'phoneNumber'       => 'string|max:255',
                'description'       => 'string',
                'status'            => 'required|integer|min:0|max:1',
                'country.id'        => 'required|integer',
                'institution.id'    => 'required|integer',
                'roles'             => 'required|array'
            ]);

        } catch (Exception $e) {
            throw new APIException('Invalid request data.', APIException::VALIDATION, $e);
        }

        $user->name         = $request->name;
        $user->email        = $request->email;
        if(isset($request->password)){
            $user->password     = password_hash($request->password, PASSWORD_BCRYPT, ['cost' => 14]);
        }
        if(isset($request->phoneNumber)){
            $user->phoneNumber = $request->phoneNumber;
        }
        if(isset($request->description)){
            $user->description = $request->description;
        }
        $user->status       = $request->status;
        $user->country      = $request->country['id'];
        $user->institution  = $request->institution['id'];

        return $user;
    }
}
