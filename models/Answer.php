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
        return [
            [
                'fields' => ['votes_number', 'text'],
                'rule' => 'required',
                'message' => 'field :name is required'
            ],
            [
                'fields' => ['text'],
                'rule' => 'unique',
                'message' => 'that :name is already taken as an answer'
            ],
        ];
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