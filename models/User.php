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
        return [
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
        ];
    }

    public function save(){
        $this->password=md5($this->password);
        parent::save();
    }
}