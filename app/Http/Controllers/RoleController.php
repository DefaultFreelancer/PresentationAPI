<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    private $limit = 20;

    public function getAllRoles(){
        try{
            DB::beginTransaction();

            $roles = Role::all();

            DB::commit();
        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json($roles);
    }

    public function getOneRole($id){
        try{
            DB::beginTransaction();

            $role = Role::findOrFail($id);

            DB::commit();
        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json($role);
    }

    public function createRole(Request $request){
        try{
            DB::beginTransaction();

            $role = new Role();

            $role->name = $request->name;

            $role->save();

            DB::commit();
        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'success'], 200);
    }

    public function updateRole($id, Request $request){
        try{
            DB::beginTransaction();

            $role = Role::findOrFail($id);

            $role->name = $request->name;

            $role->save();

            DB::commit();
        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'success'], 200);
    }

    public function deleteRole($id){
        try{
            DB::beginTransaction();

            $role = Role::findOrFail($id);

            $role->delete();

            DB::commit();
        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'success'], 200);
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

        $roles = Role::where('name', 'ilike', '%' . $input . '%')
            ->limit($this->limit)
            ->get();

        return response()->json($roles);
    }
}
