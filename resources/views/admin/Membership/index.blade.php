@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Membership <small>Listing All Memberships...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class=" active">Membership</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Info boxes -->

            <!-- /.row -->

            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">

                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-6 form-inline">
                                                <form name='filter' id="registration" class="filter  " method="get" action="{{url('admin/memberships/filter')}}">
                                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                    <div class="input-group-form search-panel ">
                                                      <select type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" name="FilterBy" id="FilterBy" >
                                                        <option value="" selected disabled hidden>{{trans('labels.Filter By')}}</option>
                                                        <option value="Name" @if(isset($name)) @if  ($name == "Name") {{ 'selected' }} @endif @endif>{{trans('labels.Name')}}</option>
                                                        <!--<option value="URL" @if(isset($name)) @if  ($name == "URL") {{ 'selected' }} @endif @endif>{{trans('labels.URL')}}</option>-->
                                                      </select>
                                                      <input type="text" class="form-control input-group-form " name="parameter" placeholder="{{trans('labels.Search')}}..." id="parameter" @if(isset($param)) value="{{$param}}" @endif>
                                                      <button class="btn btn-primary " type="submit" id="submit"><span class="glyphicon glyphicon-search"></span></button>
                                                      @if(isset($param,$name))  <a class="btn btn-danger " href="{{URL::to('admin/memberships/display')}}"><i class="fa fa-ban" aria-hidden="true"></i> </a>@endif
                                                    </div>
                                                </form>
                                                <div class="col-lg-4 form-inline" id="contact-form12"></div>
                                        </div>
                                    </div>
                                </div>

                            <div class="box-tools pull-right">
                                <a href="{{ URL::to('admin/memberships/add') }}" type="button" class="btn btn-block btn-primary">{{ trans('labels.AddNew') }}</a>
                            </div>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    @if (count($errors) > 0)
                                        @if($errors->any())
                                            <div class="alert alert-success alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                {{$errors->first()}}
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>@sortablelink('membership_id', trans('labels.ID') )</th>
                                            <th>@sortablelink( 'membership_name', trans('labels.Name') )</th>
                                            <th>Logo</th>
                                            <th>Points Limit</th>
                                            <th>Valid Till</th>
                                            <th>Discount</th>
                                            <th>Cap Value</th>
                                            <th>{{ trans('labels.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($membership)>0)
                                        
                                            @foreach ($membership  as $key=>$Membership)
                                                <tr>
                                                    <td>{{ $Membership->id }}</td>
                                                    <td>{{ $Membership->name }}</td>
                                                    <td><img src="{{asset($Membership->path)}}" alt="" width=" 100px"></td>
                                                    <td>{{ $Membership->point_from . " - " .$Membership->point_to  }}</td>
                                                    <td>
                                                        @if($Membership->has_validity == 1)
                                                            {{ $Membership->valid_till }}
                                                        @else
                                                            {{"No Validity"}}
                                                        @endif
                                                    </td>
                                                    <td>{{ $Membership->discount_percent."%" }}</td>
                                                    <td>{{ $Membership->cap_value }}</td>
                                                    <td>
                                                        
                                                        <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ URL::to('admin/memberships/edit/'.$Membership->id)}}" class="badge bg-light-blue">
                                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                        </a>
                                                        
                                                        <a id="MembershipFrom" membership_id='{{ $Membership->id }}' data-toggle="tooltip" data-placement="bottom" title="Delete" data-href="{{url('admin/memberships/delete')}}" class="badge bg-red">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </a>
                                                        
                                                    </td>
                                                </tr>
                                            @endforeach

                                        @else
                                            <tr>
                                                <td colspan="5">{{ trans('labels.NoRecordFound') }}</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                    @if($membership != null)
                                    <div class="col-xs-12 text-right">
                                        {{$membership->links()}}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Main row -->

            <!-- deleteMembershipModal -->
            <div class="modal fade" id="membershipModal" tabindex="-1" role="dialog" aria-labelledby="deleteMembershipModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="deleteMembershipModalLabel">Delete Membership</h4>
                        </div>
                        {!! Form::open(array('url' =>'admin/memberships/delete', 'name'=>'deleteMembership', 'id'=>'deleteMembership', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
                        {!! Form::hidden('membership_id',  '', array('class'=>'form-control', 'id'=>'del_membership_id')) !!}
                        <div class="modal-body">
                            <p>Are you sure you want to delete this membership?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
                            <button type="submit" class="btn btn-primary">{{ trans('labels.Delete') }}</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection
