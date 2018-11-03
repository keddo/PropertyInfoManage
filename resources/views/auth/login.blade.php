
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Adu | PM</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="/css/app.css">
</head>
<body class="hold-transition login-page">
<div class="login-box" id="app">
  <div class="login-logo">
   <img src="{{'img/logo.png'}}" alt="Adigrat Univeristy logo" class="img-circle elevation-2">
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">{{ __('Login') }} to | ADU PMS</p>

      <form method="POST" action="{{ route('login') }}">

       @csrf
        <div class="input-group mb-3">
          <input id="email" type="email" placeholder="Email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
          
          <div class="input-group-append">
              <span class="fa fa-envelope input-group-text"></span>
          </div>
          @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
          @endif
        </div>
        <div class="input-group mb-3">
          <input  placeholder="Password" id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
          @if ($errors->has('password'))
             <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('password') }}</strong>
             </span>
          @endif
          <div class="input-group-append">
              <span class="fa fa-lock input-group-text"></span>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="checkbox icheck">
              <label>
                <input type="checkbox"> Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>


      <p class="mb-1">
        <a href="#">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="{{route('register')}}" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->


<script src="/js/app.js"></script>
</body>
</html>

