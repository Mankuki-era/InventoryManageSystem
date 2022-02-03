<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Information;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return User::all();
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::find($id);
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
        if($request->admin_pass){
            $admin_pass = Information::find(1)->admin_pass;
            if(!Hash::check($request->admin_pass, $admin_pass)){
                return response()->json([
                    'caution_message'=>'パスワードが異なります.',
                ]);
            }
        }

        $user = User::find($id);

        $name = $request->familyName . " " . $request->givenName;
        $user->name = $name;
        $user->number = $request->number;
        $user->email = $request->email;
        if(isset($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->role = $request->role;
        if(isset($request->admin)) {
            $user->admin = $request->admin;
        }

        //画像が選択された場合(つまり変更される場合)
        if(isset($request->file)){
            //Storageから旧画像を削除する
            $img_path = str_replace('/storage', '', $user->img_path); // /profiles/jk...H82.png
            Storage::delete('public' . $img_path);
            // Storageに新しい画像を保存する
            $img_path = Storage::putFile('/public/profiles', $request->file); // /public/profiles/jk...H82.png
            $img_path = str_replace('public', '/storage', $img_path); // /storage/profiles/jk...H82.png
            $user->img_path = $img_path;
        }

        $user->save();

        //通知登録
        $notification = new Notification;

        $notification->type = 'UserUpdate';
        $notification->user_id = Information::find(1)->user_id;
        $notification->name = $request->familyName . " " . $request->givenName;
        $notification->price = null;
        $notification->count = null;

        $notification->save();

        return response()->json([
            'message'=>'ユーザー情報の更新が完了しました.',
        ]);

    }

    public function register(RegisterRequest $request){
        if($request->admin_pass){
            $admin_pass = Information::find(1)->admin_pass;
            if(!Hash::check($request->admin_pass, $admin_pass)){
                return response()->json([
                    'caution_message'=>'パスワードが異なります.',
                ]);
            }
        }

        $user = new User();
        $info = Information::find(1);

        $name = $request->familyName . " " . $request->givenName;
        $user->name = $name;
        $user->number = $request->number;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->admin = $request->admin;
        if(isset($request->file)){
            $img_path = Storage::putFile('/public/profiles', $request->file);
            $img_path = str_replace('public', '/storage', $img_path);
            $user->img_path = $img_path;
        }
        $user->save();
        $info->user_id = $user->id;
        $info->save();

        //通知登録
        $notification = new Notification;

        $notification->type = 'UserRegister';
        $notification->user_id = $user->id;
        $notification->name = null;
        $notification->price = null;
        $notification->count = null;

        $notification->save();

        return response()->json([
            'message'=>'新規会員登録が完了しました.',
        ]);
    }

    public function login(LoginRequest $request){

        clock("kijsi");
        $info = Information::find(1);
        $user = User::where('number', $request->number)->first();
        if(!$user){
            return response()->json([
                'message' => '職番が違います.',
                'status' => false,
            ]);
        }
        if (Hash::check($request->password, $user->password)) {
            $info->user_id = $user->id;
            $info->save();

            $admin = false;
            if($user->admin == 'assignment'){
                $admin = true;
            }

            return response()->json([
                'message'=>'ログインしました.',
                'status' => true,
                'admin' => $admin,
            ]);
        } else {
            return response()->json([
                'message'=>'パスワードが違います.',
                'status' => false,
            ]);
        }

    }
    
    public function logout(){

        $info = Information::find(1);
        $info->user_id = null;
        $info->save();
        
        return response()->json(['message' => 'ログアウトしました']);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request){
        if($request->admin_pass){
            $admin_pass = Information::find(1)->admin_pass;
            if(!Hash::check($request->admin_pass, $admin_pass)){
                return response()->json([
                    'caution_message'=>'パスワードが異なります.',
                ]);
            }
        }

        $user = new User();

        $name = $request->familyName . " " . $request->givenName;
        $user->name = $name;
        $user->number = $request->number;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->admin = $request->admin;
        if(isset($request->file)){
            $img_path = Storage::putFile('/public/profiles', $request->file);
            $img_path = str_replace('public', '/storage', $img_path);
            $user->img_path = $img_path;
        }
        $user->save();

        //通知登録
        $notification = new Notification;

        $notification->type = 'UserCreate';
        $notification->user_id = Information::find(1)->user_id;
        $notification->name = $user->name;
        $notification->price = null;
        $notification->count = null;

        $notification->save();

        return response()->json([
            'message'=>'ユーザー登録が完了しました.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $before_userName = $user->name;
        if($user->img_path !== '/image/default_user.png'){
            //Storageから旧画像を削除する
            $img_path = str_replace('/storage', '', $user->img_path); // /users/jk...H82.png
            Storage::delete('public' . $img_path);
        }
        
        $info = Information::find(1);
        if($id === $info->user_id){
            $info->user_id = null;
            $info->save();
        }

        $user->delete();

        //通知登録
        $notification = new Notification;

        $notification->type = 'UserDestroy';
        $notification->user_id = Information::find(1)->user_id;
        $notification->name = $before_userName;
        $notification->price = null;
        $notification->count = null;

        $notification->save();

        return response()->json([
            'message'=>'ユーザーの削除が完了しました.',
        ]);
    }
}
