@extends('dashboard')

@section('content')

<div>
	<div>
		hello, world 
		<span>{{ Auth::user()->name }}</span>
	</div>
</div>




@endsection