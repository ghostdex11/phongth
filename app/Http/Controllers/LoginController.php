<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    function __contruct()
    {
        if(Auth::check())
        {
            view()->share(Auth::user());
        }

    }
    public function getdangnhapAdmin()
    {
        return view('admin.login');
    }
    public function postdangnhapAdmin(Request $request)
    {

        $this->validate($request,
            [
                'email'=>'required',
                'password'=>'required|min:3|max:32'
            ],
            [
                'email.required'=>'Bạn chưa nhập email',
                'password.required'=>'bạn chưa nhập Mật khẩu',
                'password.min'=>'Mật khẩu không được nhỏ hơn 3 kí tự',
                'password.max'=>'Mật khẩu không được lớn hơn 32 kí tự'
            ]);
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password]))
        {
            $checkRole = Auth::user()->type;
            if( $checkRole == 1 ){
                return redirect('admin');
            }
            else{
                return redirect('/');
            }
        }
        else
        {
            return redirect('login')->with('thongbao','Sai mật Email hoặc Mật Khẩu');
        }
    }
    public function getdangxuatAdmin()
    {
        Auth::logout();
        return redirect('login');
    }
    public function getDangky()
    {
        return view('admin.registe');
    }
     function postDangky(Request $request)
    {
        $this->validate($request,[
            'name' =>'required|min:2',
            'msv'=>'required|min:6',
            'class'=>'required|min:4',
            'faculty'=>'required|min:3',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6|max:40',
            'passwordagain'=>'required|same:password'
        ],[
            'name.required'=>'Bạn chưa nhập tên người dùng',
            'name.min'=>'Tên người dùng phải ít nhất 2 kí tự',
            'msv.required'=>'Bạn chưa nhập mã sinh viên',
            'msv.min'=>'Mã sinh viên phải ít nhất 6 kí tự',
            'class.required'=>'Bạn chưa nhập tên lớp',
            'class.min'=>'Tên lớp phải ít nhất 4 kí tự',
            'faculty.required'=>'Bạn chưa nhập tên khoa',
            'faculty.min'=>'Tên khoa phải ít nhất 3 kí tự',
            'email.required'=>'Bạn chưa nhập email',
            'email.email'=>'Bạn chưa nhập đúng định dạng email',
            'email.unique'=>'Email đã tồn tại',
            'password.required'=>'Bạn chưa nhập Password',
            'password.min'=>'Password phải ít nhất 6 kí tự',
            'password.max'=>'Password tối đa 40 kí tự',
            'passwordagain.required'=>'Bạn chưa nhập lại mật khẩu',
            'passwordagain.same'=>'Mật khẩu nhập lại không khớp'
        ]);
        $user=new user;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->msv= $request->msv;
        $user->class= $request->class;
        $user->faculty= $request->faculty;
        $user->type=0;
        $user->save();
        return redirect('login')->with('thongbao','Đăng kí thành công');
    }
}
