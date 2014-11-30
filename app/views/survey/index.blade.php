@extends('layouts.master')

@section('head')
	@parent
	<title>Surveys</title>
@stop

@section('content')

@if(Auth::check() && Auth::user()->isAdmin())
@endif

@foreach($groups as $group)
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="clearfix">
				<h3 class="panel-title pull-left">{{ $group->title }}</h3>
				<a id="{{ $group->id }}" href="#" data-toggle="modal" data-target="#survey_form" class="btn btn-default pull-right">Add Survey</a>
				<!-- <a id="{{ $group->id }}" href="#" data-toggle="modal" data-target="#group_delete" class="btn btn-danger btn-xs pull-right">Delete</a> -->
			</div>
		</div>
		<div class="panel-body panel-list-group">
			<div class="list-group">
				@foreach($categories as $category)
					@if($category->group_id == $group->id)
						<div class="clearfix">
							<a href="{{ URL::route('survey-category', $category->id) }}" class="list-group-item">{{ $category->title }}</a>
							<a href="{{ URL::route('survey-delete-category', $category->id)}}" class="btn btn-danger btn-xs pull-right">Delete</a>
						</div>
					@endif
				@endforeach
			</div>
		</div>

	</div>
@endforeach

@if(Auth::check())
<div class="modal fade" id="survey_form" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">X</span>
						<span class="sr-only">Close</span>
					</button>
					<h4 class="modal-title">New Survey</h4>
			</div>

			<form id="target_form" method="post" action="{{ URL::route('survey-store-category') }}">
				<div class="modal-body">
					<div class="form-group{{ ($errors->has('category_name')) ? ' has-error' : ''}}">
						<label for="category_name">Survey Name:</label>
						<input type="text" id="category_name" name="category_name" class="form-control">
						@if($errors->has('category_name'))
						<p>{{ $errors->first('category_name') }} </p>
						@endif
					</div>
					{{ Form::token() }}
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<input type="submit" value = "Save" class="btn btn-primary">
				</div>
			</form>

		</div>
	</div>
</div>

<div class="modal fade" id="survey_delete" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">X</span>
					<span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Delete Survey:</h4>
			</div>
			<form id="target_form" method="post" action="{{ URL::route('survey-delete-category') }}">
				<div class="modal-body">
					<h3>Are you sure you want to delete survey?</h3>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<a href="#" type="button" class="btn btn-primary" id="btn_delete_survey">Yes</a>
				</div>
			</form>
		</div>
	</div>
</div>
@endif
@stop

<!-- @section('javascript')
	@parent
	<script type="text/javascript" src="/js/app.js"></script>
	@if(Session::has('modal'))
	<script type="text/javascript">
	$( "{{Session::get('modal')}}" ).modal('show');
	</script>
	@endif
@stop -->
