<?php


namespace models;


class User extends Model{

    public $attributes=[
        'id'=>0,
        'email'=>'',
        'password'=>''
    ];


    public function rules()
    {
        return array_merge(parent::rules(),[
            [
                'fields' => ['email', 'password'],
                'rule' => 'required',
                'message' => 'field :name is required'
            ],
            [
                'fields' => ['email'],
                'rule' => 'unique',
                'message' => 'field :name is already taken'
            ],
            [
                'fields' => ['email'],
                'rule' => 'email',
                'message' => 'field :name is not valid email'
            ],
        ]);
    }

    public function save(){
        $this->password=md5($this->password);
        parent::save();
    }
}