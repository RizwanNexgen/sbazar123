@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Splash Screen
                <small>Listing the Splash Screens for app...</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i
                                class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active">Splash Screen</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Info boxes -->
            <!-- /.row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs"> </ul>
                                        <form method="{{url('admin/homebanners/insert')}}" action="" class="form-horizontal" enctype='multipart/form-data'>

                                        <div class="">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="form-group">
                                                        <label for="name" class="col-sm-2 col-md-3 control-label">1st Screen</label>
                                                        <div class="col-sm-10 col-md-4">
                                                            <!-- Modal -->
                                                            <input type="file" name="1st"> </div> @if(!empty($banner['path']))
                                                            <div class="form-group">
                                                                <label for="name" class="col-sm-2 col-md-3 control-label"></label>
                                                                <div class="col-sm-10 col-md-4"> <img src="{{asset($banner['path'])}}" alt="" width=" 100px"> </div>
                                                            </div> @endif </div>
                                                    <div class="form-group">
                                                        <label for="name" class="col-sm-2 col-md-3 control-label">2nd Screen</label>
                                                        <div class="col-sm-10 col-md-4">
                                                            <!-- Modal -->
                                                            <input type="file" name="1st"> </div> @if(!empty($banner['path']))
                                                            <div class="form-group">
                                                                <label for="name" class="col-sm-2 col-md-3 control-label"></label>
                                                                <div class="col-sm-10 col-md-4"> <img src="{{asset($banner['path'])}}" alt="" width=" 100px"> </div>
                                                            </div> @endif </div>
                                                    <div class="form-group">
                                                        <label for="name" class="col-sm-2 col-md-3 control-label">3rd Screen</label>
                                                        <div class="col-sm-10 col-md-4">
                                                            <!-- Modal -->
                                                            <input type="file" name="1st"> </div> @if(!empty($banner['path']))
                                                            <div class="form-group">
                                                                <label for="name" class="col-sm-2 col-md-3 control-label"></label>
                                                                <div class="col-sm-10 col-md-4"> <img src="{{asset($banner['path'])}}" alt="" width=" 100px"> </div>
                                                            </div> @endif </div>
                                                    <div class="form-group">
                                                        <label for="name" class="col-sm-2 col-md-3 control-label">4th Screen</label>
                                                        <div class="col-sm-10 col-md-4">
                                                            <!-- Modal -->
                                                            <input type="file" name="1st"> </div> @if(!empty($banner['path']))
                                                            <div class="form-group">
                                                                <label for="name" class="col-sm-2 col-md-3 control-label"></label>
                                                                <div class="col-sm-10 col-md-4"> <img src="{{asset($banner['path'])}}" alt="" width=" 100px"> </div>
                                                            </div> @endif </div>
                                                    <div class="form-group">
                                                        <label for="name" class="col-sm-2 col-md-3 control-label">5th Screen</label>
                                                        <div class="col-sm-10 col-md-4">
                                                            <!-- Modal -->
                                                            <input type="file" name="1st"> </div> @if(!empty($banner['path']))
                                                            <div class="form-group">
                                                                <label for="name" class="col-sm-2 col-md-3 control-label"></label>
                                                                <div class="col-sm-10 col-md-4"> <img src="{{asset($banner['path'])}}" alt="" width=" 100px"> </div>
                                                            </div> @endif </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.tab-pane -->
                                    </div>
                                    <div class="box-footer text-center">
                                        <button type="submit" class="btn btn-primary pull-right" id="normal-btn">{{ trans('labels.Submit') }}</button>
                                    </div>
                                    </form>
                                    <!-- /.tab-content -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
    <!-- /.row -->
    <!-- Main row -->
    <!-- /.row -->
    </section>
    <!-- /.content -->
    </div>
    <script src="{!! asset('admin/plugins/jQuery/jQuery-2.2.0.min.js') !!}"></script>
@endsection