@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
           @include('user.user_dashboard_sidebar')
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    All Ticket <a href="{{ route('new.ticket') }}" class="btn btn-sm btn-primary" style="float:right;">Open Ticket</a>
                </div>

                <div class="card-body">
                   <div>
                       <table class="table">
                         <thead>
                           <tr>
                             <th scope="col">Date</th>
                             <th scope="col">Service</th>
                             <th scope="col">Subject</th>
                             <th scope="col">Status</th>
                             <th scope="col">Action</th>
                           </tr>
                         </thead>
                         <tbody>
                          @foreach($ticket as $row)
                           <tr>
                             <th scope="row">{{ date('d F, Y'), strtotime($row->date) }}</th>
                             <td>{{ $row->service }}</td>
                             <td>{{ $row->subject }}</td>
                             <td>
                              @if($row->status==0)
                                  <span class="badge badge-danger">Pending</span>
                              @elseif($row->status==1)
                                  <span class="badge badge-success">Replied</span>
                              @elseif($row->status==2)
                                  <span class="badge badge-muted">Closed</span>
                              @endif
                            </td>
                            <td>
                              <a href="{{ route('show.ticket', $row->id) }}" class="btn btn-sm btn-info" title="view order"><i class="fa fa-eye"></i></a>
                            </td>
                           </tr>
                           @endforeach
                         </tbody>
                       </table>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div><hr>

@endsection
