<?php

namespace App\Http\Controllers\DBFunctions;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;


class DBFunctionsController extends Controller
{
    /**
	 * add a record to a table.
	 *
	 * @return Response
	 */
	public function insert($table, $fields) {
		$entity = new $table ();
		$allValues = "";
		
		foreach ( $fields as $key => $value ) {
			$entity [$key] = $value;
			// echo $key." ".$value;
			// die();
			$allValues = $allValues . $value . ", ";
		}
		$entity ["createdBy"] = Auth::user()->id;
		// print_r($entity);
		// die();
		$ret_val = $entity->save ();
		
		// $fields = array ();
		// $fields ['transactionType'] = "INSERT";
		// $fields ['tableName'] = $table;
		// $fields ['recId'] = $entity->id;
		// $fields ['oldValues'] = "";
		// $fields ['newValues'] = $allValues;
		// $table = "App\models\DBTransactions";
		// $entity = new $table ();
		// foreach ( $fields as $key => $value ) {
		// 	$entity [$key] = $value;
		// }
		// $entity ["createdBy"] = Auth::user()->id;;
		// $fields ['insertedBy'] = Auth::user()->Fname;
		// $entity->save ();
		\Session::flash ( 'email_message', $fields );
		return $ret_val;
	}
	
	public function insert1($table, $fields) {
		$entity = new $table ();
		$allValues = "";
		
		foreach ( $fields as $key => $value ) {
			$entity [$key] = $value;
			// echo $key." ".$value;
			// die();
			$allValues = $allValues . $value . ", ";
		}
		
		// print_r($entity);
		// die();
		$ret_val = $entity->save ();
		
		// $fields = array ();
		// $fields ['transactionType'] = "INSERT";
		// $fields ['tableName'] = $table;
		// $fields ['recId'] = $entity->id;
		// $fields ['oldValues'] = "";
		// $fields ['newValues'] = $allValues;
		// $table = "App\models\DBTransactions";
		// $entity = new $table ();
		// foreach ( $fields as $key => $value ) {
		// 	$entity [$key] = $value;
		// }
		// // $entity ["createdBy"] = Auth::user()->id;;
		// // $fields ['insertedBy'] = Auth::user()->Fname;
		// $entity->save ();
		\Session::flash ( 'email_message', $fields );
		return $ret_val;
	}

	/**
	 * add a record to a table.
	 *
	 * @return Response
	 */
	public function insertRetId($table, $fields) {
		$entity = new $table ();
		$allValues = "";
		foreach ( $fields as $key => $value ) {
			$entity [$key] = $value;
			$allValues = $allValues . $value . ", ";
		}
		$entity ["createdBy"] = Auth::user()->id;
		$entity->save ();
		$ret_val = $entity->id;
		
		// $fields = array ();
		// $fields ['transactionType'] = "INSERT";
		// $fields ['tableName'] = $table;
		// $fields ['recId'] = $entity->id;
		// $fields ['oldValues'] = "";
		// $fields ['newValues'] = $allValues;
		// $table = "App\models\DBTransactions";
		// $entity = new $table ();
		// foreach ( $fields as $key => $value ) {
		// 	$entity [$key] = $value;
		// }
		// $entity ["createdBy"] = Auth::user ()->id;
		// $fields ['insertedBy'] = Auth::user()->Fname;
		// $entity->save ();
		\Session::flash ( 'email_message', $fields );
		return $ret_val;
	}
	public function insertRetId1($table, $fields) {
		$entity = new $table ();
		$allValues = "";
		foreach ( $fields as $key => $value ) {
			$entity [$key] = $value;
			$allValues = $allValues . $value . ", ";
		}
		$entity ["createdBy"] = Auth::user()->id;
		$entity->save ();
		$ret_val = $entity->id;
		
		// $fields = array ();
		// $fields ['transactionType'] = "INSERT";
		// $fields ['tableName'] = $table;
		// $fields ['recId'] = $entity->id;
		// $fields ['oldValues'] = "";
		// $fields ['createdBy'] = Auth::user()->id;
		// $fields ['newValues'] = $allValues;
		// $table = "App\models\DBTransactions";
		// $entity = new $table ();
		// foreach ( $fields as $key => $value ) {
		// 	$entity [$key] = $value;
		// }
		// // $entity ["createdBy"] = Auth::user ()->id;
		// // $fields ['insertedBy'] = Auth::user()->Fname;
		// $entity->save ();
		\Session::flash ( 'email_message', $fields );
		return $ret_val;
	}
	
	/**
	 * update a record of a table
	 *
	 * @return Response
	 */
	public function update($table, $fields, $data) {
		 //print_r($data); print_r($table); print_r($fields); //die();
		$tfields = array ();
		$newValues = "";
		$oldValues = "";
		foreach ( $fields as $key => $value ) {
			$tfields [] = $key;
			$newValues = $newValues . $value . ", ";
		}
		// print_r($fields);
		// die();
		// print_r($tfields);
		// die();
		$rec = $table::where ( 'id', "=", $data ['id'] )->select ( $tfields )->get ();
		// print_r($rec);
		// die();
		if (count ( $rec ) > 0) {
			$rec = $rec [0];
			foreach ( $tfields as $tfield ) {
				$oldValues = $oldValues . $rec [$tfield] . ", ";
			}
		}
		
		$fields ["updatedBy"] = Auth::user()->id;
		$ret_val = $table::where ( 'id', $data ['id'] )->update ( $fields );
		
		// $fields = array ();
		// $fields ['transactionType'] = "UPDATE";
		// $fields ['tableName'] = $table;
		// $fields ['recId'] = $data ['id'];
		// $fields ['oldValues'] = $oldValues;
		// $fields ['newValues'] = $newValues;
		// $table = "\App\models\DBTransactions";
		// $entity = new $table ();
		// foreach ( $fields as $key => $value ) {
		// 	$entity [$key] = $value;
		// }
		// $entity ["createdBy"] = Auth::user()->id;
		// $fields ['insertedBy'] = Auth::user()->Fname;
		// $entity->save ();
		\Session::flash ( 'email_message', $fields );
		return $ret_val;
	}

	public function update1($table, $fields, $data) {
		///print_r($data); print_r($table); print_r($fields); //die();
	   $tfields = array ();
	   $newValues = "";
	   $oldValues = "";
	   foreach ( $fields as $key => $value ) {
		   $tfields [] = $key;
		   $newValues = $newValues . $value . ", ";
	   }
	//    print_r($fields);
	//    die();
	   // print_r($fields);
	   // die();
	   // print_r($tfields);
	   // die();
	   //$rec = $table::where ( 'id', "=", $data ['id'] )->select ( $tfields )->get ();
	//    print_r($rec);
	//    die();
	//    if (count ( $rec ) > 0) {
	// 	   $rec = $rec [0];
	// 	   foreach ( $tfields as $tfield ) {
	// 		   $oldValues = $oldValues . $rec [$tfield] . ", ";
	// 	   }
	//    }
	   
	   $fields ["updatedBy"] = Auth::user()->id;
	   $ret_val = $table::where ( 'id', $data ['id'] )->update($fields);
	   
	   $fields = array ();
	   $fields ['transactionType'] = "UPDATE";
	   $fields ['tableName'] = $table;
	   $fields ['recId'] = $data ['id'];
	   $fields ['oldValues'] = $oldValues;
	   $fields ['newValues'] = $newValues;
	   $table = "\App\models\DBTransactions";
	   $entity = new $table ();
	   foreach ( $fields as $key => $value ) {
		   $entity [$key] = $value;
	   }
	   $entity ["createdBy"] = Auth::user()->id;
	   $fields ['insertedBy'] = Auth::user()->Fname;
	   $entity->save ();
	   \Session::flash ( 'email_message', $fields );
	   return $ret_val;
   }
	
	/**
	 * get a record from a table
	 *
	 * @return Response
	 */
	public function get($table, $fields) {
		// print_r($data); print_r($table); print_r($fields); die();
		return $table::where ( $fields )->get ();
    }
    public function delete($table,$fields1,$data)
    {
        $fields = array ();
		$fields ['transactionType'] = "DELETE";
		$fields ['tableName'] = $table;
		$fields ['recId'] = $data ['id'];
		$fields ['oldValues'] = $fields1;
		$fields ['newValues'] = "";
		$table = "\App\models\DBTransactions";
		$entity = new $table ();
		foreach ( $fields as $key => $value ) {
			$entity [$key] = $value;
		}
		$entity ["createdBy"] = Auth::user()->id;
		$fields ['insertedBy'] = Auth::user()->Fname;
		$entity->save ();
    }

}
