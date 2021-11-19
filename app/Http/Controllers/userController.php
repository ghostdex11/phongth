<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class userController extends Controller
{
    public function index(){
        $user = db::table('users')->get();
        return view('admin/user/listuser',['user'=>$user]);
    }
    public function addUser(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'msv'=>'required',
            'class'=>'required',
            'faculty'=>'required',
            'email'=>'required|unique:users,email',
            'password'=>'required|min:5',
            'passwordagain'=>'required|same:password'
        ],[
            'name.required'=>'Bạn chưa nhập tên người dùng',
             'msv.required'=>'Bạn chưa nhập mã sinh viên',
            'class.required'=>'Bạn chưa nhập lớp',
            'faculty.required'=>'Bạn chưa nhập tên khoa',
            'email.required'=>'Bạn chưa nhập email',
            'email.unique'=>'Email đã tồn tại',
            'password.required'=>'Bạn chưa nhập mật khẩu',
            'password.min'=>'Mật khẩu phải có ít nhất 5 kí tự',
            'passwordagain.required'=>'Bạn chưa nhập lại mật khẩu',
            'passwordagain.same'=>'Mật khẩu nhập lại không khớp'
        ]);
        if(!$validator->passes()){
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }else{
            $user=new User;
            $user->name=$request->name;
            $user->msv=$request->msv;
            $user->class=$request->class;
            $user->faculty=$request->faculty;
            $user->email=$request->email;
            $user->password=Hash::make($request->password);
            $user->type=$request->type;
            $user->save();
            // return redirect('admin/user');
           if( $user){
               return response()->json(['status'=>1, 'msg'=>'Bạn đăng kí thành công']);
                }
        }
    
    }
    public function detailUser($id)
    {
        return $user = user::find($id);
    }
    public function editUser(Request $request)
    {

        $id=$request->id;
        User::where('id',$id)->update([
            'name'=>$request->name,
            'msv'=>$request->msv,
            'class'=>$request->class,
            'faculty'=>$request->faculty,
            'type'=>$request->type
        ]);
        if($request->changePassword =="on")
        {
            $this->validate($request,
                [
                    'password'=>'required|min:5',
                    'passwordagain'=>'required|same:password'
                ],
                [
                    'password.min'=>'Mật khẩu phải có ít nhất 5 kí tự',
                    'passwordagain.required'=>'Bạn chưa nhập lại mật khẩu',
                    'passwordagain.same'=>'Mật khẩu nhập lại không khớp'
                ]);
            User::where('id',$id)->update([ 'password'=>Hash::make($request->password)]);
        }
        return redirect('admin/user')->with('thongbao','Bạn đã sửa thành công');
    }
    public function deleteUser($id){
        User::find($id)->delete();
    }
}
