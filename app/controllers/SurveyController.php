<?php

class SurveyController extends BaseController
{
	public function index()
	{	//all is method with eloquence that say get all records in database
		$groups = SurveyGroup::all();
		$categories = SurveyCategory::all();
		return View::make('survey.index')->with('groups', $groups)->with('categories', $categories);
	}

	public function category($id)
	{
			$category = SurveyCategory::find($id);
			$threads = SurveyThread::all();
			if($category == null)
			{
				return Redirect::route('survey-home')->with('fail', 'That category doesn\'t exist');
			}
			return View::make('survey.category')->with('category', $category)->with('threads', $threads);
	}

	public function thread($id)
	{
	}

	public function storeGroup()
	{
		$validator = Validator::make(Input::all(), array(
			'group_name'=>'required|unique:survey_groups,title'
		));
		if($validator->fails())
		{
			return Redirect::route('survey-home')->withInput()->withErrors($validator)->with('modal','#group_form');
		}
		else
		{
			$group = new SurveyGroup;
			$group->title = Input::get('group_name');
			$group->author_id = Auth::user()->id;

			if($group->save())
			{
				return Redirect::route('survey-home')->with('success', 'The group was created');
			}
			else
			{
				return Redirect::route('survey-home')->with('fail', 'An error has occured while saving.');
			}
		}
	}

	public function storeCategory()
	{
		$validator = Validator::make(Input::all(), array(
			'category_name'=>'required|unique:survey_categories,title'
		));
		if($validator->fails())
		{
			return Redirect::route('survey-home')->withInput()->withErrors($validator)->with('modal','#survey_form');
		}
		else
		{
			$category = new SurveyCategory;
			$category->title = Input::get('category_name');
			$category->group_id = 1;
			$category->author_id = Auth::user()->id;

			if($category->save())
			{
				return Redirect::route('survey-home')->with('success', 'The survey was successfully created.');
			}
			else
			{
				return Redirect::route('survey-home')->with('fail', 'An error has occured while saving.');
			}
		}

	}
	public function deleteGroup($id)
	{
		$group = ServeyGroup::find($id);
		if($group == null)
		{
			return Redirect::route('survey-home')->with('fail', 'That group doesn\'t exist.');
		}

		$categories = SurveyCategory::where('group_id', $id);
		$delCategories = true;
		if($categories->count() > 0)
		{
			$delCategories->delete();
		}
		$delGroup = $group->delete();
		if($delCategories && $delGroup)
		{
			return Redirect::route('survey-home')->with('success', 'The group was deleted.');
		}
		else
		{
			return Redirect::route('survey-home')->with('fail', 'An error occured while delteing the group.');
		}
	}
	public function deleteCategory($id)
	{
		$category = SurveyCategory::find($id);
		if($category == null)
		{
			return Redirect::route('survey-category')->with('fail', 'That category doesn\'t exist.');
		}
		$threads = SurveyThread::where('category_id', $id);
		$delThreads = true;
		if($threads->count() > 0)
		{
			$delThreads=$threads->delete();
		}
		$delCategories = $category->delete();
		if($delCategories && $delThreads)
		{
			return Redirect::route('survey-home')->with('success', 'The survey was deleted.');
		}
		else
		{
			return Redirect::route('survey-home')->with('fail', 'An error occured while deleteing the survey.');
		}
	}
}
