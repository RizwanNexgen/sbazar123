@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Points Setting<small>Points Setting...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li class="active">Points Setting</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Points Setting</h3>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-info">
                                    <!--<div class="box-header with-border">
                                          <h3 class="box-title">Setting</h3>
                                        </div>-->
                                    <!-- /.box-header -->
                                    <!-- form start -->
                                    <div class="box-body">
                                        @if( count($errors) > 0)
                                        @foreach($errors->all() as $error)
                                        <div class="alert alert-success" role="alert">
                                            <span class="icon fa fa-check" aria-hidden="true"></span>
                                            <span class="sr-only">Points Setting:</span>
                                            {{ $error }}</div>
                                        @endforeach
                                        @endif

                                        {!! Form::open(array('url' =>'admin/updateSetting', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                                        

                                
                                        
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Welcome Bonus</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('points_welcome_bonus', $result['commonContent']['setting']['points_welcome_bonus'], array('class'=>'form-control', 'id'=>'points_welcome_bonus')) !!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">
                                                    When new user register 
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Profile Completion</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('points_profile_finish', $result['commonContent']['setting']['points_profile_finish'], array('class'=>'form-control', 'id'=>'points_profile_finish')) !!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">
                                                    When user completed profile
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Birthday Gift</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('points_birthday', $result['commonContent']['setting']['points_birthday'], array('class'=>'form-control', 'id'=>'points_birthday')) !!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">
                                                    On user birthday, system will send automatic greeting with points
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Referral Purchase (%)</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('points_ref_commission_rate', $result['commonContent']['setting']['points_ref_commission_rate'], array('class'=>'form-control', 'id'=>'points_ref_commission_rate')) !!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">
                                                    When referred user purchase item from shop
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Writing review or rating app</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('points_review_post', $result['commonContent']['setting']['points_review_post'], array('class'=>'form-control', 'id'=>'points_review_post')) !!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">
                                                    When user write a review or rating app
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Points Settings</label>
                                            <div class="col-sm-10 col-md-4">
                                                <label class=" control-label" style="margin-right:10px;">
                                                      <input type="radio" name="points_system_enabled" value="Y" class="flat-red" @if($result['commonContent']['setting']['points_system_enabled'] == 'Y') checked @endif > Enabled
                                                </label>
                                                <label class=" control-label">
                                                      <input type="radio" name="points_system_enabled" value="N" class="flat-red" @if($result['commonContent']['setting']['points_system_enabled'] == 'N') checked @endif >  Disabled
                                                </label>
                                            </div>
                                        </div>
                                        
                                    <div class="box-footer text-center">
                                        <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                        <a href="{{ URL::to('admin/dashboard/this_month')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
                                    </div>
                                    <!-- /.box-footer -->
                                    {!! Form::close() !!}
                                </div>
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
@endsection
