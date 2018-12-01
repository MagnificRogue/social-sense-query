@extends('layouts.app')

@section('content')
<div class="row" style='margin-left: 20px'>
	<h3> We're really happy that you're interested in our system! If you could provide the following bits of info, we will be in contact shortly. </h3>
	<form action="/applications" method="POST">
		@csrf
	  <div class="form-group">
		<label for="name">Name</label>
		<input  type="text" 
				class="form-control" 
				id="name" name="name" 
				aria-describedby="nameHelp" 
				placeholder="Enter the name of the application" 
				required
				value="{{ old('name')}}">

		</input>
		@if($errors->has('name'))
			<div class="alert alert-danger"> {{ $errors->first('name')}} </div>
		@endif
	

		<small id="nameHelp" class="form-text text-muted">What is the name of this application? (This is only used to help you figure out what this application is)</small>
			  </div>

	  <div class="form-group">
		<label for="home">Home</label>
		<input 
			type="text" 
			class="form-control" 
			id="home" 
			name="home" 
			aria-describedby="homeHelp" 
			placeholder="What URL can you access this application at?" 
			required
			value="{{old('home')}}">

		@if($errors->has('home'))
			<div class="alert alert-danger"> {{ $errors->first('home')}} </div>
		@endif

		<small id="homeHelp" class="form-text text-muted"> Enter a link that the user may access the homepage of their application at</small>
	  </div>
	
	 <div class="form-group">
		<label for="callback">Callback Url</label>
		<input  type="text" 
				class="form-control" 
				id="callback" 
				name="callback" 
				aria-describedby="callbackHelp"
				placeholder="We need a URL to send data to your application. We call this URL a callback url. What is that URL?" 
				required
				value="{{old('callback')}}">

		@if($errors->has('callback'))
			<div class="alert alert-danger"> {{ $errors->first('callback')}} </div>
		@endif


		<small id="callbackHelp" class="form-text text-muted"> We need a URL to send data to your application. We call this URL a callback URL. What is that URL?</small>
	  </div>


	  <div class="form-group">
		<label for="description">Feel free to add a description for the application here. It, however, isn't necessary.</label>
		<textarea class="form-control" id="description" name="description" rows="3" > {{ old('description') }} </textarea>
	  </div>
	  <button type="submit" class="btn btn-primary">Submit</button>
	</form>
</div>

@endsection
