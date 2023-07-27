<?php

namespace db;

use models\Model;

interface ActiveRecord{

    function select($fields=[])
    : ActiveRecord;

    function where($condition)
    : ActiveRecord;

    function leftJoin($joinTable, $onCondition)
    : ActiveRecord;

    function orderBy($fields)
    : ActiveRecord;

    function all();

    function one();

    function insert($fields)
    : ActiveRecord;

    function update($fields)
    : ActiveRecord;

    function delete()
    : ActiveRecord;

    function execute()
    : int;


}