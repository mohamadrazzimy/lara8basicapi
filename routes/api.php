<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/hello', function () {
    return( 'hello');
});

Route::get('/init', function () {

        Schema::dropIfExists('staff');        

        if (!Schema::hasTable("staff")) {

            Schema::create("staff", function (Blueprint $table) {

                $table->id();

                $table->string("s_name");

                $table->string("s_email")->unique();

                $table->string("s_dept");

                $table->string("s_bran");

            });

        }

        if (Schema::hasTable("staff")) {

            DB::delete('delete from staff');

            DB::insert('insert into staff (s_name,s_email,s_dept,s_bran) 

            values (?,?,?,?)',

            ['john','john@gmail.com','D1','D1B1']);

            DB::insert('insert into staff (s_name,s_email,s_dept,s_bran) 

            values (?,?,?,?)',

            ['nancy','nancygmail.com','D2','D2B2']);

        }

        Schema::dropIfExists('dept');        

        if (!Schema::hasTable("dept")) {

            Schema::create('dept', function (Blueprint $table) {

                $table->id();

                $table->string('s_code')->unique();  

                $table->string('s_name');            

            });

        }

        if (Schema::hasTable("dept")) {

            DB::delete('delete from dept');

            DB::insert('insert into dept (s_code,s_name) values (?,?)', 

            ['D1','Department 1']);   

            DB::insert('insert into dept (s_code,s_name) values (?,?)', 

            ['D2','Department 2']);   

        }

        Schema::dropIfExists('bran');

        if (!Schema::hasTable("bran")) {

            Schema::create('bran', function (Blueprint $table) {

                $table->id();

                $table->string('s_code')->unique();  

                $table->string('s_dept');                    

                $table->string('s_name');            

            });

        }

        if (Schema::hasTable("bran")) {

            DB::delete('delete from bran');

            DB::insert('insert into bran (s_dept,s_code,s_name) 

            values (?,?,?)', 

            ['D1','D1B1','Branch 1 of D1']);   

            DB::insert('insert into bran (s_dept,s_code,s_name) 

            values (?,?,?)', 

            ['D1','D1B2','Branch 2 of D1']);   

            DB::insert('insert into bran (s_dept,s_code,s_name) 

            values (?,?,?)', 

            ['D2','D2B1','Branch 1 of D2']);   

            DB::insert('insert into bran (s_dept,s_code,s_name) 

            values (?,?,?)', 

            ['D2','D2B2','Branch 2 of D2']);    

        }           

        

        /*create json data*/

        $json_data =

            '{"table":["staff","dept","bran"],"status":"init"}';

        /*convert json object to php object*/

        $result = json_decode($json_data);

        /**/

        return response()->json($result, 200);

});


Route::get('/table', function () {

        /*mysql*/

        //$table_collection =  DB::select('SHOW TABLES'); 

        /*sqlite*/

        $result = DB::select("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name;");

        return response()->json($result, 200);

});

Route::get('/{table}/desc',function($table){
    
       $result = Schema::getColumnListing($table);

        return response()->json($result, 200);

});

Route::get('/{table}/record',function($table){
    
        $result = DB::select("select * from " . $table);

        return response()->json($result, 200);

});