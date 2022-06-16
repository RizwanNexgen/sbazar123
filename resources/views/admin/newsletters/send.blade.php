@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ trans('labels.Send Newsletter') }} <small>{{ trans('labels.Send Newsletter') }}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li><a href="{{ URL::to('admin/newsletters/display')}}"><i class="fa fa-gears"></i> {{ trans('labels.Newsletters') }}</a></li>
            <li class="active">{{ trans('labels.Send Newsletter') }}</li>
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
                        <h3 class="box-title">{{ trans('labels.Send Newsletter') }} </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-info">
                                    <br>
                                    @if (count($errors) > 0)
                                        @if($errors->any())
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            {{$errors->first()}}
                                        </div>
                                        @endif
                                    @endif
                                    @if(session()->has('success'))
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            {{ session()->get('success') }}
                                    </div>
                                    @endif
                                    @if(session()->has('error'))
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            {{ session()->get('error') }}
                                    </div>
                                    @endif
                                    <!-- /.box-header -->
                                    <!-- form start -->
                                    <div class="box-body">
                                        <form action="" method="POST">
                                            @csrf  
                                            <div class="form-group">
                                                <label>Select User Level</label>
                                                <select class="form-control" name="level_type">
                                                    <option value="">All</option>
                                                    @foreach($user_level_types as $user_level_type)
                                                    <option value="{{$user_level_type->id}}">{{$user_level_type->level_title}}</option>
                                                    @endforeach                                                    
                                                </select>
                                            </div>  
                                            <div class="form-group">
                                                <label>Email Subject</label>
                                                <input type="text" class="form-control" value="{{$info->subject}}" name="subject" />
                                            </div>
                                            <div class="form-group">
                                                <label>Email Body</label>
                                                <textarea class="form-control ckeditor" name="description" rows="3">{{$info->description}}</textarea>                        
                                            </div>                                                                   
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">Send</button>
                                            </div>
                                        </form> 
                                       
                                    </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- /.box-body -->

        <!-- /.box -->

        <!-- /.col -->

        <!-- /.row -->

        <!-- Main row -->

        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
@endsection
