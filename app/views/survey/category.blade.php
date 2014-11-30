@extends('layouts.master')

@section('head')
  @parent
  <title>Survey | {{ $category->title }}</title>
@stop

@section('content')

@if(Auth::check() && Auth::user()->isAdmin())
@endif

<h3>{{ $category->title }}<span class="label label-default"></span></h3>
@if( $category->author_id == Auth::id() || Auth::user()->isAdmin())
  <div>
    <a href="#" data-toggle="modal" data-target="#question_form" class="btn btn-default">Add Question</a>
  </div>
@endif
<form role="form" method="post" action="{{ URL::route('survey-submit', $category->id) }}">
  @foreach($threads as $thread)
    <!--<a href="#" class="btn btn-danger btn-xs pull-right">Delete</a>-->
    @if($thread->category_id == $category->id)
      <label>{{ $thread->body }}</label>
      <input id="answer{{$thread->id}}" name="answer{{$thread->id}}" type="text" class="form-control">
    @endif
  @endforeach
  {{ Form::token() }}
  <div class="form-group">
      <input type="submit" value = "Submit Answers" class="btn btn-default">
  </div>
</form>


@if(Auth::check())
<div class="modal fade" id="question_form" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">X</span>
          <span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title">New Question: </h4>
      </div>

      <form id="target_form" method="post" action="{{ URL::route('survey-store-questions', $category->id) }}">
        <div class="modal-body">
          <div class="form-group{{ ($errors->has('question')) ? ' has-error' : ''}}">
            <label for="question">Question:</label>
            <input type="text" id="question" name="question" class="form-control">
            @if($errors->has('question'))
            <p>{{ $errors->first('question') }} </p>
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

@endif

@stop
