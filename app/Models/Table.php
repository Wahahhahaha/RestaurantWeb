<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Table extends Model
{
    function show($table){
        return DB::table($table)->get();
    }

    function order($table,$order){
        return DB::table($table)->orderBy($order);
    }

    function where($table,$where){
        return DB::table($table)->where($where)->get()->first();
    }

    function wheres($table,$where){
        return DB::table($table)->where($where)->get();
    }

    function regis($table,$data){
        return DB::table($table)->insertGetId($data);
    }

    function login($table1, $table2, $table3, $where, $on, $on2){
        return DB::table($table1)
        ->leftJoin($table2, $on[0], $on[1], $on[2])
        ->leftJoin($table3, $on2[0], $on2[1], $on2[2])
        ->select(
            "$table1.userid as userid",
            "$table1.username",
            "$table1.password",
            "$table1.levelid",
            "$table2.buyerid",
            "$table3.employerid",
            "$table3.roleid"
        )
        ->where($where)
        ->first();
    }

    function remove($table,$where){
        return DB::table($table)->where($where)->delete();
    }

    function edit($table,$where,$data){
        return DB::table($table)->where($where)->update($data);
    }

    function add($table,$data){
        return DB::table($table)->insert($data);
    }

    function join ($table1,$table2,$on){
        return DB::table($table1)->leftjoin($table2, $on[0], $on[1],$on[2])->first();
    }

    function joinwhere($table1, $table2,$table3, $on ,$on1,$where){
        return DB::table($table1)
        ->leftjoin($table2, $on[0], $on[1], $on[2])
        ->leftjoin($table3, $on1[0], $on1[1], $on1[2])
        ->where($where)
        ->first();
    }

    function join3 ($table,$table2,$table3,$on,$on2){
        return DB::table($table)->leftjoin($table2, $on[0], $on[1],$on[2])
        ->leftjoin($table3, $on2[0], $on2[1],$on2[2])
        ->first();
    }

    function join3g ($table,$table2,$table3,$on,$on2){
        return DB::table($table)->leftjoin($table2, $on[0], $on[1],$on[2])
        ->leftjoin($table3, $on2[0], $on2[1],$on2[2])
        ->get();
    }


    function join4g ($table,$table2,$table3,$table4,$on,$on2,$on3){
        return DB::table($table)->leftjoin($table2, $on[0], $on[1],$on[2])
        ->leftjoin($table3, $on2[0], $on2[1],$on2[2])
        ->leftjoin($table4, $on3[0], $on3[1],$on3[2])
        ->get();
    }

    function GetId($table, $data){
       return DB::table($table)->insertGetId($data);
   }
}
