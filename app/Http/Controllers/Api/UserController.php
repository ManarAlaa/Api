<?php

namespace App\Http\Controllers\Api;
use App\Traits\response;
Use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use response;
    public function index (Request $request){
        $index = User::where(function($query) use ($request){
            $query->where('id', $request->id);
        })->get();
        return $this->jsnResponse('successful' , 'done' , $index);

    }
   
    public function create(Request $request){
        $rules = [
            'name'=>'required|string',
            'email'=>'email|unique:users,email',
            'password'=>'min:5'


        ];


        $ValidData = validator()->make($request->all(), $rules);

        if ($ValidData->fails()) {
            return $this->jsnResponse('fail','error',$ValidData->errors());
        } else {

        $request->merge(['password'=> bcrypt($request->password)]);
        $create= User:: create($request->all());

      return $this->jsnResponse('sucessful','done',$create) ;
  
      }
     
    }
    public function update(Request $request){
        $rules = [
            'name'=>'required|string',
            'email'=>'email|unique:users,email',
            'password'=>'min:5' ];


        $ValidData = validator()->make($request->all(), $rules);

        if ($ValidData->fails()) 
        {
            return $this->jsnResponse('fail','error',$ValidData->errors());
        }
         else
        {

         $request->merge(['password'=> bcrypt($request->password)]);
         $record = User::findorfail($request->id);
         $update= $record-> update($request->all());

         return $this->jsnResponse('sucessful','done',$update) ;
  
        }
     


    }
    public function delete(request $request)  
    {
        $record = User::findorfail($request->id);
        $record->delete();
        return $this->jsnResponse('sucessful','deleted') ;
    }

}

