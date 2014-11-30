<?php

class SurveyTableSeeder extends Seeder
{
	public function run()
	{
		SurveyGroup::create(array(
			'title' => 'Surveys',
			'author_id' => 1
		));

		SurveyCategory::create(array(
			'group_id' => 1,
			'title' => 'Test Category 1',
			'author_id' => 1
		));

		SurveyCategory::create(array(
			'group_id' => 1,
			'title' => 'Test Category 2',
			'author_id' => 1
		));
	}
}
