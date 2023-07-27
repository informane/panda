<?php

namespace models;

use http\Exception;
use ReflectionClass;

class Model{
    public $attributes=[
        'id'=>0
    ];

    public static function activeRecord(){
        global $facade;
        $activeRecordClass="db\\" . ucfirst($facade->dbms) . 'ActiveRecord';
        return new $activeRecordClass(get_called_class());
    }

    public function __get($name){
        if (key_exists($name, $this->attributes)){
            return $this->attributes[$name];
        } else {
            return $this->$name;
        }
    }

    public function __set($name, $value){
        if (key_exists($name, $this->attributes)){
            $this->attributes[$name]=$value;
        } else {
            $this->$name=$value;
        }
    }

    public function rules(){
        return [];
    }

    public function validate(){
        $messages=['errors'=>[]];
        foreach ($this->rules() as $rule){
            if ($rule['rule'] == 'required'){
                foreach ($rule['fields'] as $field){
                    if ($this->$field == null || $this->$field == ''){
                        $messages['errors'][$field][]=str_replace(':name', $field, $rule['message']);
                    }
                }
            }
            if ($rule['rule'] == 'unique'){
                foreach ($rule['fields'] as $field){
                    $user=get_called_class()::activeRecord()->select([$field,'id'])->where([$field=>$this->$field])->one();
                    if ($user && $user->id != $this->id){
                        $messages['errors'][$field][]=str_replace(':name', $field, $rule['message']);
                    }
                }
            }
        }
        if (!count($messages['errors']))
            return true;
        else
            $messages['result']='fail';
        return $messages;
    }

    public function load($userData){
        foreach ($userData as $attr=>$attrValue){
            $this->$attr=$attrValue;
        }
    }

    public function save(){
        if ($this->id != null && $this->id != 0 && $this->id != ''){
            if(!$this::activeRecord()->update($this->attributes)->where(['id'=>$this->id])->execute())
            {
                return false;
            }
            return $this->id;
        } else {
            return $this->id=$this::activeRecord()->insert($this->attributes)->execute();
        }

    }

    public static function delete($id=0){
        if ($id) return self::activeRecord()->delete()->where(['id'=>$id])->execute();
        else return self::activeRecord()->delete()->execute();
    }

    public function tableName(){
        return strtolower(basename(get_class($this)));
    }
}