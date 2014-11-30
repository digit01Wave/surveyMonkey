<?php

class QuestionController extends BaseController
{

  public function storeQuestions($cat_id)
  {
    $validator = Validator::make(Input::all(), array(
      'question'=>'required'
    ));
    if($validator->fails())
    {
      return Redirect::route('survey-category', $cat_id)->withInput()->withErrors($validator)->with('modal','#question_form');
    }
    else
    {
      $thread = new SurveyThread;
      $thread->title = "Question";
      $thread->body = Input::get('question');
      $thread->group_id = 1;
      $thread->category_id = $cat_id;
      $thread->author_id = Auth::user()->id;
      if($thread->save())
      {
        return Redirect::route('survey-category', $cat_id)->with('success', 'The question was successfully added.');
      }
      else
      {
        return Redirect::route('survey-category', $cat_id)->with('fail', 'An error has occured while saving.');
      }
    }
  }

  public function storeAnswers($cat_id)
  {
    $threads = SurveyThread::where('category_id', $cat_id);
    $rules_array = array();
    foreach($threads as $thread)
    {
      $rules_array['answer'."$thread->id"] = 'required';
    }
    $validator = Validator::make(Input::all(), $rules_array);
    if($validator->fails())
    {
      return Redirect::route('survey-category', $cat_id)->withInput()->with('fail', 'Not all questions were answered. Please try again.');
    }
    else
    {
      $comment = new SurveyComment;
      $comment->body = "Answer Start:";
      foreach($threads as $thread){
        $comment->body .= Input::get('answer'."$thread->id");
        $comment->body.=";";
      }
      $comment->group_id = 1;
      $comment->thread_id = 1; //group and threads are still being worked out
      $comment->category_id = $cat_id;
      $comment->author_id = Auth::user()->id;
      if($comment->save())
      {
        return Redirect::route('survey-category', $cat_id)->with('success', 'The answers were successfully submitted.');
      }
      else
      {
        return Redirect::route('survey-category', $cat_id)->with('fail', 'An error has occured while saving.');
      }
    }
  }

}
?>
