@extends('templates.login-template')

@section('content')
	<section class="panel panel-default">
        <header class="panel-heading">Sign in</header>
        <div class="bg-white user pd-lg">
            <h6>
                <strong>Welcome.</strong>Sign in to get started!</h6>

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <!-- Email Form Input -->
                    <div class="form-group">

                        {!! Form::email('email', null, ['class' => 'form-control','placeholder'=>'Username']) !!}
                        {!! errors_for('email',$errors) !!}
                    </div>
                    <!-- Password Form Input -->
                    <div class="form-group">

                        {!! Form::password('password', ['class' => 'form-control','placeholder'=>'Password']) !!}
                        {!! errors_for('password',$errors) !!}
                    </div>
                    <!-- Log In Form Input -->
                    <div class="form-group">
                        {!! Form::submit('Sign in', ['class' => 'btn btn-info btn-block']) !!}
                        {!! link_to('password/email', 'Forgot password?') !!}
                    </div>
            </form>


        </div>
  </section>
@endsection