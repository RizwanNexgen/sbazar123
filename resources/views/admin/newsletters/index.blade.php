@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> {{ trans('labels.Newsletters') }} <small>{{ trans('labels.ListingAllNewsletters') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active">{{ trans('labels.Newsletters') }}</li>
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
                            <div class="box-tools pull-right">
                                <a href="{{ URL::to('admin/newsletters/add')}}" type="button" class="btn btn-block btn-primary"><i class="fa fa-plus-circle"></i> {{ trans('labels.AddNew') }}</a>
                            </div>
                            </br>
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
                                            <th>{{ trans('labels.ID') }}</th>
                                            <th>{{ trans('labels.Subject') }}</th>                                            
                                            <th>{{ trans('labels.Created') }}</th>
                                            <th width="20%">{{ trans('labels.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($list)>0)
                                            @foreach ($list as $key=>$o)
                                                <tr>
                                                    <td>{{ $o->id }}</td>
                                                    <td>{{ $o->subject }}</td>                                                        
                                                    <td>{{ $o->created_at }}</td>
                                                    <td>
                                                        <a href="{{url('admin/newsletters/edit/'.$o->id)}}" class="btn btn-sm btn-primary">Edit</a>
                                                        <a onClick="return confirm('Sure to delete?')" href="{{url('admin/newsletters/delete/'.$o->id)}}" class="btn btn-sm btn-danger">Delete</a>                                                        
                                                        <a href="{{url('admin/newsletters/send/'.$o->id)}}" class="btn btn-sm btn-success">Send</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7">{{ trans('labels.NoRecordFound') }}</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                    @if($list != null)
                                      <div class="col-xs-12 text-right">
                                          {{$list->links()}}
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

            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection
