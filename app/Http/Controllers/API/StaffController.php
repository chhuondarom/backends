<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\Validator;
use DB;
class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staff = Staff::all();
        return $this->sendResponse(true, 'Staff is get successfully', $staff);
    }

    function search(Request $request){
        $staff_id = $request->input('staff_id');
        $gener = $request->input('gender');
        $star_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $staff = DB::table("tblstaff")
        ->where("gender", $gener)
        ->orwhere("id_no", $staff_id)
        ->orwhereBetween('tblstaff.dob', [$star_date,$end_date,])
        ->get();
      return $this->sendResponse(true, 'Staff is added successfully', $staff);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($status, $message, $result){
        $response = [
            'status' => $status,
            'message' => $message,
            'data' => $result
        ];

        return response()->json($response, 200);
    }
    public function sendError($status, $message, $code){
        $response = [
            'status' => $status,
            'message' => $message,
            'code' =>$code
        ];
        return response()->json($response, $code);
    }
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'full_name' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'id_no' => 'required',
        ]);
        if ($validate->fails()) {
            return $this->sendError(false, $validate->messages(), 500);
        }
      $staff = new Staff();
      $staff-> full_name = $request->get("full_name");
      $staff-> dob = $request->get("dob");
      $staff-> gender = $request->get("gender");
      $staff-> id_no = $request->get("id_no");
      $staff->save();
      return $this->sendResponse(true, 'Staff is added successfully', $staff);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $staff = Staff::find($id);
     
        return $this->sendResponse(true, 'Staff is Updated successfully', $staff);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        $staff = Staff::find($id);
        if( ! $staff ){
            return $this->sendError(false, "ID Id not found", 500);
        }else{
           
            $staff-> full_name = $request->full_name;
            $staff-> dob = $request->dob;
            $staff-> gender = $request->gender;
            $staff-> id_no = $request->id_no;

            $staff->save();
            return $this->sendResponse(true, 'Staff is Updated successfully', $staff);
        }
     
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $staff = Staff::find('1');
      $staff-> full_name = $request->get("full_name");
      $staff-> dob = $request->get("dob");
      $staff-> gender = $request->get("gender");
      $staff-> id_no = $request->get("id_no");

      $staff->save();
      return $this->sendResponse(true, 'Staff is Updated successfully', $staff);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $staff = Staff::find($id);
        if(!$staff){
            return $this->sendError(false, "ID Id not found", 500);
        }else{
            $staff->delete();
            return $this->sendResponse(true, 'Delete successfully!', $staff);
        }
       
    }
}
