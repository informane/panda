<?php


namespace models;


class Question extends Model{

    public $attributes=[
        'id'          =>0,
        'user_id'     =>0,
        'status'      =>0,
        'text'        =>'',
        'date_created'=>''
    ];

    const STATUSES=[
        1=>'draft',
        2=>'published'
    ];


    public function rules(){
        return array_merge(parent::rules(),[
            [
                'fields' =>['status', 'text'],
                'rule'   =>'required',
                'message'=>'field :name is required'
            ],
            [
                'fields' => ['text'],
                'rule' => 'unique',
                'message' => 'that :name is already taken as a question'
            ],
        ]);
    }

    public function save(){
        if ($this->date_created=='')
            $this->date_created=date('Y-m-d H:i:s');
        return parent::save();
    }

    public static function delete($id=0){
        $question=Question::activeRecord()->select()->where(['id'=>$id,'user_id'=>$_SESSION['user_id']])->one();
        if($question!=null){
            return parent::delete($id);
        } else {
            return false;
        }
    }
}