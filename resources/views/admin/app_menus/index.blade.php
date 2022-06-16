@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Menubar </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active">Menubar</li>
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
                                <a href="{{ URL::to('admin/appmenus/add')}}" type="button" class="btn btn-block btn-primary"><i class="fa fa-plus-circle"></i> {{ trans('labels.AddNew') }}</a>
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
                                            <th width="10%">ID</th>
                                            <th width="15%">Background/Icon</th> 
                                            <th>Title</th>                                            
                                            <th>Type</th>
                                            <th width="20%">{{ trans('labels.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($list)>0)
                                            @foreach ($list as $key=>$o)
                                                <tr>
                                                    <td>{{ $o->id }}</td>
                                                    <td>
                                                        @if($o->menu_type=='Main')
                                                            <div class="thumbnail">
                                                                <img src="{{asset('storage/app/backgrounds/'.$o->bg_image)}}" class="img-fluid" />
                                                            </div>
                                                        @else 
                                                            <div class="thumbnail">
                                                                <img src="{{asset('storage/app/icons/'.$o->icon)}}" class="img-fluid" />
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>{{ $o->title }}</td>                                                        
                                                    <td>{{ $o->menu_type }}</td>
                                                    <td>
                                                        <a href="{{url('admin/appmenus/edit/'.$o->id)}}" class="btn btn-sm btn-primary">Edit</a>
                                                        <a onClick="return confirm('Sure to delete?')" href="{{url('admin/appmenus/delete/'.$o->id)}}" class="btn btn-sm btn-danger">Delete</a>                                                        
                                                        
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
