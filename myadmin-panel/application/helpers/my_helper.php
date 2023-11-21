<?php

if (!function_exists('getWhereClause')) {

    function getWhereClause($col, $oper, $val) {

	$ops = array(
	    'eq' => '=', //equal
	    'ne' => '<>', //not equal
	    'lt' => '<', //less than
	    'le' => '<=', //less than or equal
	    'gt' => '>', //greater than
	    'ge' => '>=', //greater than or equal
	    'bw' => 'LIKE', //begins with
	    'bn' => 'NOT LIKE', //doesn't begin with
	    'in' => 'LIKE', //is in
	    'ni' => 'NOT LIKE', //is not in
	    'ew' => 'LIKE', //ends with
	    'en' => 'NOT LIKE', //doesn't end with
	    'cn' => 'LIKE', // contains
	    'nc' => 'NOT LIKE'  //doesn't contain
	);

	if ($oper == 'bw' || $oper == 'bn')
	    $val .= '%';
	if ($oper == 'ew' || $oper == 'en')
	    $val = '%' . $val;
	if ($oper == 'cn' || $oper == 'nc' || $oper == 'in' || $oper == 'ni')
	    $val = '%' . $val . '%';
	return " AND $col {$ops[$oper]} '$val' ";
    }

}