<?php


namespace models;


class Answer extends Model{

    public $attributes=[
        'id'=>0,
        'question_id'=>0,
        'votes_number'=>0,
        'text'=>''
    ];

    const STATUSES=[
        1=>'draft',
        2=>'published'
    ];

    public function rules()
    {
        return array_merge(parent::rules(),[
            [
                'fields' => ['votes_number', 'text'],
                'rule' => 'required',
                'message' => 'field :name is required'
            ],
            [
                'fields' => ['votes_number'],
                'rule' => 'numeric',
                'message' => 'field :name must be numeric'
            ],
        ]);
    }

    public static function sync($question_id, $answers){
        $existingAnswers=Answer::activeRecord()->select()->where(['question_id'=>$question_id])->all();
        foreach ($existingAnswers as $existingAnswer){
            if (!in_array($existingAnswer, $answers)){
                Answer::delete($existingAnswer->id);
            }
        }
        foreach ($answers as $answer){
            $answer->save();
        }
    }

}