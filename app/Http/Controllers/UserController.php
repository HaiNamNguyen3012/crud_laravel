<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

//Thêm thư viện để ma hóa password
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create(){
        return view('users.create');
    }

    public function store(Request $request){
        //Kiem tra xem du lieu tu client gui len bao gom nhung gi
//        dd($request);

        // gán dữ liệu gửi lên biến data
        $data = $request->all();
//        dd($data);

        //ma hoa password trước khi đẩy ln DB

        $data['password'] = Hash::make($request->password);

        //Tao moi user voi du lieu tuong ung voi du lieu duoc gan trong $data
        User::create($data);
        echo"Success create user";
    }

    public function edit($id){
        //Tim doi tuong muon update
        $user = User::findOrFail($id);

        //Dieu huong den view edit user va truyen sang du lieu ve user muon sua doi
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id){
        // Tìm đến đối tượng muốn update
        $user = User::findOrFail($id);

        // gán dữ liệu gửi lên vào biến data
        $data = $request->all();
        // dd($data);
        // mã hóa password trước khi đẩy lên DB
        $data['password'] = Hash::make($request->password);

        // Update user
        User::find($id)->update($data);
        echo"success update user";

    }

    public function delete($id){
        //Tim doi tuong muon xoa
        $user = User::findOrFail($id);

        $user->delete();
        echo"success delete user";
    }
    public function index(){
        // lấy ra toàn bộ user
        $users = User::orderBy('id', 'desc')->paginate(5);
        //dd($users);

        // trả về view hiển thị danh sách user
        return view('users.index', compact('users'));
    }
}
