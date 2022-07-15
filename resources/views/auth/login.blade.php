@extends('layouts.app')
@section('content')
  <img class="wave" src="img/wave.png">
	<div class="container">
		<div class="img">
			<img src="img/bg.svg">
		</div>
		<div class="login-content">
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <img src="img/avatar.svg">
        <h2 class="title">Welcome</h2>
        <div class="input-div one">
            <div class="i">
              <i class="fas fa-user"></i>
            </div>
            <div class="div">
              <input autocomplete="nope" class="input" type="email" name="email" value="{{ old('email') }}" required placeholder='Tài khoản'>
            </div>
        </div>
          @error('email')
            <span style='color:red;'>
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        <div class="input-div pass">
            <div class="i"> 
              <i class="fas fa-lock"></i>
            </div>
            <div class="div">
              <input type="password" class="input" id="password" name="password" required autocomplete="new-password" placeholder='Mật khẩu'>
            </div>
        </div>
        @error('password')
          <span style='color:red;'>
              <strong>{{ $message }}</strong>
          </span>
        @enderror
        <input type="submit" class="btn" value="Login">
      </form>
    </div>
  </div>
  <script type="text/javascript" src="js/login.js"></script>
@endsection
