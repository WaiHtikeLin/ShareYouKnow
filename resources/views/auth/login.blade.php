@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" id="loginform">
                        @csrf

                        <div class="form-group row">

                            <p class="invalid-feedback text-center" role="alert" style="display: block;">
                                        <strong id="incorrect"></strong>
                                    </p>

                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>

                                
                                    <span class="invalid-feedback" role="alert" style="display: block;">
                                        <strong id="errors_email"></strong>
                                    </span>
                            
                               
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">

                                
                                    <span class="invalid-feedback" role="alert" style="display: block;">
                                        <strong id="errors_pass"></strong>
                                    </span>

                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                        

                    </form>

                    
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

        });

    $("#loginform").on("submit",function(e)
    {
        e.preventDefault();
        var f=new FormData(this);
        var email=f.get('email');
        var password=f.get('password');
        var remember=f.get('remember');

        $.ajax({
                    url: "/login",
                    type: "POST",
                    data:  {email:email,password:password,remember:remember},
                    success: function()
                    {   
                        location.replace("/home");
                    }
                    ,
                    error: function(xhr, status, err) {

    var data = JSON.parse(xhr.responseText);

    var incorrect=data.errors.incorrect ? data.errors.incorrect : "";
    var mailerrors=data.errors.email ? data.errors.email : "";
    var passerrors=data.errors.password ? data.errors.password : "";

    $("#incorrect").text(incorrect);
    $("#errors_email").text(mailerrors);
    $("#errors_pass").text(passerrors);
    // do stuff with your error messages presumably...
}
                });


    });
</script>
@endsection
