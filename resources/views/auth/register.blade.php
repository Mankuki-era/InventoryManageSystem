@extends('layouts.app')
@push('script')
  <script src="{{ asset('js/register.js') }}"></script>
@endpush
@push('css')
  <link href="{{ asset('css/user/register.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="wrapper">
    <main>
        <div class="empty">
            <h1>
            <a href="../index.html">
                <p class="h1_sub main_title">情報通信工学科実験室</p>
                <p class="main_title2">在庫管理システム</p>
                <p class="main_title2">新規会員登録ページ</p>
            </a>
            </h1>
        </div>
        <div class="signup_control">
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf

                <h2>SIGN UP</h2>
                <div class="staff_name">
                    <!--- 名字の入力欄  ---->
                    <div class="family_name">
                        <p class="named_ID">FAMILY NAME <span class="required_mark">*</span> </p>
                        <input type="text" name="family_name" value="{{ old('family_name') }}" class="FormOfms @error('family_name') is-invalid @enderror" autocomplete="family-name">
                        @error('family_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!--- 名前の入力欄  ---->
                    <div class="given_name">
                        <p class="named_ID">GIVEN NAME <span class="required_mark">*</span> </p>
                        <input type="text" name="given_name" value="{{ old('given_name') }}" class="FormOfms @error('given_name') is-invalid @enderror" autocomplete="given-name">
                        @error('given_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="full_space_form">
                    <!--- 職番の入力  ---->
                    <p class="named_ID">STAFF NUMBER <span class="required_mark">*</span> </p>
                    <input type="number" name="number" value="{{ old('number') }}" maxlength="5" step="1" class="FormOfms @error('number') is-invalid @enderror" required>
                    @error('number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <!--- パスワード入力  ---->
                    <p class="named_ID">PASSWORD <span class="required_mark">*</span> </p>
                    <input type="password" name="password" class="FormOfms @error('password') is-invalid @enderror" id="submit_password" autocomplete="new-password" required>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <!--- パスワード確認入力  ---->
                    <p class="named_ID">CONFIRM PASSWORD <span class="required_mark">*</span> </p>
                    <input type="password" name="password_confirmation" class="FormOfms" autocomplete="new-password" required>

                    <!--- 昼夜勤の判断のためのボタン  ---->
                    <p class="named_ID">DAYTIME OR NIGHTTIME <span class="required_mark">*</span> </p>
                    <fieldset>
                        <!--- 昼勤の選択ボタン  ---->
                        <input id="DAYTIME" type="radio" name="role" value="DAYTIME" class="day_or_night" checked="checked" required>
                        <label for="DAYTIME" class="job_timezone">DAYTIME</label>

                        <!--- 夜勤の選択ボタン  ---->
                        <input id="NIGHTTIME" type="radio" name="role" value="NIGHTTIME" class="day_or_night">
                        <label for="NIGHTTIME" class="job_timezone">NIGHTTIME</label>
                    </fieldset>

                    <!--- 管理者権限を付与するかどうかのボタン  ---->
                    <p class="named_ID">ADMINISTRATOR RIGHTS <span class="required_mark">*</span> </p>
                    <fieldset>
                        <!--- 管理者にはならない人向けの選択ボタン  ---->
                        <input id="nonassignment" type="radio" name="admin" value="nonassignment" class="assignment_or_not" checked="checked" onclick="pw_in_hid(false)">
                        <label for="nonassignment" class="adm_rights">NONASSIGNMENT</label>
                        
                        <!--- 管理者になる人向けの選択ボタン  ---->
                        <input id="assignment" type="radio" name="admin" value="assignment" class="assignment_or_not" onclick="pw_in_dis(true)">
                        <label for="assignment" class="adm_rights">ASSIGNMENT</label>
                    </fieldset>

                    <!--- 管理者になる人に課すパスワード入力欄 ---->
                    <div class="password_for_assignment" id="password_for_assignment">
                        <p class="named_ID pw_box">CONFIRM PASSWORD FOR ASSIGNMENT <span class="required_mark">*</span> </p>
                        <input type="password" name="admin_password" class="FormOfms pw_box @error('password') is-invalid @enderror" id="pw_box_adm">
                    </div>
                    @error('admin_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <!--- プロフィール画像選択 ---->
                    <p class="named_ID">PROFILE IMAGE</p>
                    <div id="attachment">
                        <label><input type="file" name="img_path" class="fileinput" accept="image/png, image/jpeg"/>ファイルを添付する</label>
                        <span class="filename">選択されていません</span>
                    </div>

                    <!--- 最終登録ボタン  ---->
                    <div>
                        <button type="submit" class="register_button">
                            {{ __('Register') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="empty"></div>
    </main>
</div>
@endsection