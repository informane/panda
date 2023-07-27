<?php

namespace db;

use models\Model;
use PDO;

class MysqlActiveRecord implements ActiveRecord{

    public $modelType;
    protected $tableName;
    protected $queryType;
    protected $sqlString;
    protected $selectPart;
    protected $leftJoinPart;
    protected $wherePart;
    protected $orderByPart;
    protected $insertPart;
    protected $updatePart;
    protected $deletePart;
    protected $whereParams=[];
    protected $insertParams=[];

    public function __construct($modelType){
        $this->modelType=$modelType;
        $modelTypeArr=explode('\\',$this->modelType);
        $this->tableName=strtolower(array_pop($modelTypeArr));
    }

    protected function clearSql(){
        $this->queryType='';
        $this->sqlString='';
        $this->selectPart='';
        $this->leftJoinPart='';
        $this->wherePart='';
        $this->orderByPart='';
        $this->insertPart='';
        $this->updatePart='';
        $this->deletePart='';
        $this->whereParams=[];
        $this->insertParams=[];
    }

    public function select($fields=['*'])
    : ActiveRecord{
        $this->queryType='select';
        $this->whereParams=[];
        $fields=implode(', ', $fields);

        $this->selectPart="SELECT {$fields} from {$this->tableName} ";

        return $this;
    }

    public function leftJoin($joinTable, $onCondition)
    : ActiveRecord{
        $conditionArray=[];
        foreach ($onCondition as $key=>$item){
            $conditionArray[]="{$key}={$item}";
        }
        $onCondition=implode(' AND ', $conditionArray);
        $this->leftJoinPart=" left join {$joinTable} on {$onCondition} ";
        return $this;
    }

    public function where($condition)
    : ActiveRecord{
        $this->whereParams=[];
        $conditionArray=[];
        foreach ($condition as $key=>$item){
            $param=str_replace('.','_',$key);
            $conditionArray[]="{$key}=:{$param}";
            $this->whereParams[$param]=$item;
        }

        $this->wherePart=" where ".implode(' AND ', $conditionArray);

        return $this;
    }

    public function orderBy($fields)
    : ActiveRecord{
        if(count($fields)){
            $this->orderByPart=" order by " . implode(', ', $fields);
        }
        return $this;
    }

    /**
     * @return Model[]
     */
    public function all()
    : array{
        global $facade;
        $pdo=$facade->dbConnection->pdo;
        $this->sqlString=$this->selectPart.$this->leftJoinPart.$this->wherePart.$this->orderByPart;
        $stmt=$pdo->prepare($this->sqlString);
        $stmt->execute($this->whereParams);
        $models=[];
        $i=0;
        while ($row=$stmt->fetch(PDO::FETCH_ASSOC)){
            $models[$i]=new $this->modelType;
            foreach ($row as $fieldName=>$fieldValue){
                $models[$i]->$fieldName=$fieldValue;
            }
            $i++;
        }
        $this->clearSql();
        return $models;
    }

    public function one()
    {
        global $facade;
        $pdo=$facade->dbConnection->pdo;
        $this->sqlString=$this->selectPart.$this->leftJoinPart.$this->wherePart.$this->orderByPart;
        $stmt=$pdo->prepare($this->sqlString);
        $stmt->execute($this->whereParams);
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        $model=new $this->modelType;
        if($row){
            foreach ($row as $fieldName=>$fieldValue){
                $model->$fieldName=$fieldValue;
            }
            $this->clearSql();

            return $model;
        } else {
            return false;
        }
    }

    public function insert($fields)
    : ActiveRecord{
        $this->queryType='insert';
        $fieldParams=[];
        foreach ($fields as $fieldName=>$fieldValue){
            $fieldParams[]=":$fieldName";
            $this->insertParams[$fieldName]=$fieldValue;
        }
        $fieldParams=implode(',', $fieldParams);
        $fields=implode(',', array_keys($fields));
        $this->insertPart="insert into {$this->tableName}({$fields}) Values({$fieldParams})";

        return $this;
    }

    public function update($fields)
    : ActiveRecord{
        $this->queryType='update';
        $fieldParams=[];
        foreach ($fields as $fieldName=>$fieldValue){
            $fieldParams[]="{$fieldName}='{$fieldValue}'";
        }
        $fieldParams=implode(', ', $fieldParams);
        $this->updatePart="update {$this->tableName} SET {$fieldParams} ";


        return $this;
    }

    public function delete()
    : ActiveRecord{
        $this->queryType='delete';
        $this->deletePart="delete from {$this->tableName} ";

        return $this;
    }

    public function execute()
    : int{
        global $facade;
        $pdo=$facade->dbConnection->pdo;

        $result=false;
        if ($this->queryType == 'insert'){
            $this->sqlString=$this->insertPart;
            $stmt=$pdo->prepare($this->sqlString);
            $stmt->execute($this->insertParams);
            $result=$pdo->lastInsertId();
        }
        if ($this->queryType == 'update'){
            $this->sqlString=$this->updatePart.$this->wherePart;
            $stmt=$pdo->prepare($this->sqlString);
            $result=$stmt->execute($this->whereParams);
        }
        if ($this->queryType == 'delete'){
            $this->sqlString=$this->deletePart.$this->wherePart;
            $stmt=$pdo->prepare($this->sqlString);
            $result=$stmt->execute($this->whereParams);
        }
        $this->clearSql();

        return $result;
    }
}