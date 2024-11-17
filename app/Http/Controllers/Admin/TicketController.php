<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Image;

class TicketController extends Controller
{
        public function __construct()
        {
            $this->middleware('auth');
        }

        //ticket index method
        public function index(Request $request)
    {
         if ($request->ajax()) {

            $ticket="";
              $query=DB::table('tickets')->leftJoin('users','tickets.user_id','users.id');
                   
                if ($request->date) {
                    $query->where('tickets.date',$request->date);
                 }

                 if ($request->type=='technical') {
                    $query->where('tickets.service',$request->type);
                 }
                 if ($request->type=='payment') {
                    $query->where('tickets.service',$request->type);
                 }
                 if ($request->type=='affiliate') {
                    $query->where('tickets.service',$request->type);
                 }
                 if ($request->type=='return') {
                    $query->where('tickets.service',$request->type);
                 }
                 if ($request->type=='refund') {
                    $query->where('tickets.service',$request->type);
                 }

                if ($request->status==1) {
                     $query->where('tickets.status',1);
                }

                if ($request->status==0) {
                    $query->where('tickets.status',0);
                }

                if ($request->status==2) {
                    $query->where('tickets.status',2);
                }

            $ticket=$query->select('tickets.*','users.name')->get();
            return DataTables::of($ticket)
                    ->addIndexColumn()
                    ->editColumn('status',function($row){
                        if ($row->status==1) {
                            return '<span class="badge badge-warning"> Running </span>';
                        }elseif($row->status==2){
                            return '<span class="badge badge-muted"> Close </span>';
                        }else{
                            return '<span class="badge badge-danger"> Pending </span>';
                        }
                    })
                    ->editColumn('date',function($row){
                       return date('d F Y',strtotime($row->date));
                    })
                    ->addColumn('action', function($row){
                        $actionbtn='
                        <a href="'.route('view.ticket',[$row->id]).'" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                        <a href="'.route('admin.ticket.delete',[$row->id]).'" class="btn btn-danger btn-sm" id="delete_ticket"><i class="fas fa-trash"></i>
                        </a>';
                       return $actionbtn;   
                    })
                    ->rawColumns(['action','status','date'])
                    ->make(true);       
        }
        return view('admin.ticket.index');
    }

    //show ticket method
    public function viewticket($id)
    {
        $ticket=DB::table('tickets')->leftJoin('users','tickets.user_id','users.id')->select('tickets.*','users.name')->where('tickets.id',$id)->first();
            return view('admin.ticket.view_ticket',compact('ticket'));
    }

    //admin ticket reply store method
    public function replyticket(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required',
            ]);

          $data=array();
          $data['message']=$request->message;
          $data['ticket_id']=$request->ticket_id;
          $data['user_id']=0;
          $data['reply_date']=date('Y-m-d');
          
          if ($request->image) {
            $photo=$request->image;
            $photoname=uniqid().'.'.$photo->getClientOriginalExtension();
            Image::make($photo)->resize(600,350)->save('public/files/ticket/'.$photoname); //image intervention
            $data['image']='public/files/ticket/'.$photoname; //public/files/brand/plus-point.jpg
          }
            

          DB::table('replies')->insert($data);
          DB::table('tickets')->where('id',$request->ticket_id)->update(['status'=>1]);

          $notification=array('message' => 'Replied Done!','alert-type'=>'success' );
          return redirect()->back()->with($notification);
    }

    //admin close ticket method
    public function closeticket($id)
    {
        DB::table('tickets')->where('id',$id)->update(['status'=>2]);

        $notification=array('message' => 'Closed Ticket!','alert-type'=>'success' );
          return redirect()->route('ticket.index')->with($notification);
    }

    //admin ticket delete method
    public function destroy($id)
    {
        DB::table('tickets')->where('id',$id)->delete();
        return response()->json('Successfully Deleted!');
    }

}
