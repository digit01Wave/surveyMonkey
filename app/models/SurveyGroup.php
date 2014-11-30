<?php

class SurveyGroup extends Eloquent
{
	protected $table = 'survey_groups';

	public function categories()
	{
		return $this->hasMany('SurveyCategory', 'group_id');
	}
	
}
