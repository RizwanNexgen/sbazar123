@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Faq <small>Listing all the faq...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class=" active">Faq</li>
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
                                                &nbsp;
                                        </div>
                                    </div>
                                </div>

                            <div class="box-tools pull-right">
                                <a href="{{ URL::to('admin/faq/add') }}" type="button" class="btn btn-block btn-primary">{{ trans('labels.AddNew') }}</a>
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
                                            <th>ID</th>
                                            <th>Question</th>                                            
                                            <th>Answer</th>
                                            <th>Category</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($list)>0)
                                            @foreach ($list  as $o)
                                            <tr>
                                                <td>{{ $o->id }}</td>
                                                <td>{{ $o->question }}</td>
                                                <td>{{ $o->answer }}</td>                                               
                                                <td>{{ $o->faq_cat_name }}</td>
                                                <td>
                                                    <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ URL::to('admin/faq/edit/'.$o->id)}}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                    <a data-toggle="tooltip" data-placement="bottom" title="Delete" onClick="return confirm('Sure to delete?')" href="{{url('admin/faq/delete/'.$o->id)}}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>

                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6">No records found.</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                    
                                    <div class="col-xs-12 text-right">
                                        {{$list->links()}}
                                    </div>
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
