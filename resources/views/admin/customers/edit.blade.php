@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ trans('labels.EditCustomers') }} <small>{{ trans('labels.EditCurrentCustomers') }}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li><a href="{{ URL::to('admin/customers/display')}}"><i class="fa fa-users"></i> {{ trans('labels.ListingAllCustomers') }}</a></li>
            <li class="active">{{ trans('labels.EditCustomers') }}</li>
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
                        <h3 class="box-title">{{ trans('labels.EditCustomers') }} </h3>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-info">
                                    <!--<div class="box-header with-border">
                                          <h3 class="box-title">Edit category</h3>
                                        </div>-->
                                    <!-- /.box-header -->
                                    <br>
                                    @if (count($errors) > 0)
                                      @if($errors->any())
                                      <div class="alert alert-danger alert-dismissible" role="alert">
                                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                          {{$errors->first()}}
                                      </div>
                                      @endif
                                    @endif


                                    <!-- form start -->
                                    <div class="box-body">

                                        {!! Form::open(array('url' =>'admin/customers/update', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

                                        {!! Form::hidden('customers_id', $data['customers']->id, array('class'=>'form-control', 'id'=>'id')) !!}

                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.FirstName') }}* </label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('first_name', $data['customers']->first_name, array('class'=>'form-control field-validate', 'id'=>'first_name')) !!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.FirstNameText') }}</span>
                                                <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.LastName') }}*</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('last_name', $data['customers']->last_name , array('class'=>'form-control field-validate', 'id'=>'last_name')) !!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.lastNameText') }}</span>
                                                <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                            </div>
                                        </div>
                                       
                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Telephone') }}</label>
                                          <div class="col-sm-10 col-md-4">
                                            {!! Form::text('phone',  $data['customers']->phone, array('class'=>'form-control phone-validate', 'id'=>'phone')) !!}
                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.TelephoneText') }}</span>
                                          </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.changePassword') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::checkbox('changePassword', 'yes', null, ['class' => '', 'id'=>'change-passowrd']) !!}
                                            </div>
                                        </div>

                                        <!-- <div class="form-group password_content">-->
                                        <div class="form-group password" style="display: none">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Password') }}*</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::password('password', array('class'=>'form-control ', 'id'=>'password')) !!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    {{ trans('labels.PasswordText') }}</span>
                                                <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">City</label>
                                            <div class="col-sm-10 col-md-4">
                                              {!! Form::text('city',  $data['customers']->city, array('class'=>'form-control', 'id'=>'city')) !!}                                              
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Country</label>
                                            <div class="col-sm-10 col-md-4">
                                              <select class="form-control select2" name="country_code">
                                                    <option value="">--Select--</option>
                                                    @foreach($data['countries'] as $country)
                                                    <option value="{{$country->countries_iso_code_2}}" @if($data['customers']->country_code==$country->countries_iso_code_2) selected @endif>{{$country->countries_name}}</option>
                                                    @endforeach
                                              </select>                                             
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Referral ID</label>
                                            <div class="col-sm-10 col-md-4">
                                              {!! Form::text('referral_id',  $data['customers']->referral_id, array('class'=>'form-control', 'id'=>'referral_id')) !!}
                                              <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">e.g. SBSAJA2092</span>                                              
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">SPoints</label>
                                            <div class="col-sm-10 col-md-4">
                                              {!! Form::text('spoints',  $data['customers']->spoints, array('class'=>'form-control', 'id'=>'spoints')) !!}                                                                                            
                                              <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">This points are defined for user level</span>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Premium Points</label>
                                            <div class="col-sm-10 col-md-4">
                                              {!! Form::text('ppoints',  $data['customers']->ppoints, array('class'=>'form-control', 'id'=>'ppoints')) !!}    
                                              <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">This points are defined for redeem products</span>                                                                                        
                                            </div>
                                          </div>
                                        
                                        <hr>
                                          <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Gender</label>
                                            <div class="col-sm-10 col-md-4">
                                              <select class="form-control" name="gender">
                                                    <option value="Male" @if($data['customers']->gender=='Male') selected @endif>Male</option>
                                                    <option value="Female" @if($data['customers']->gender=='Female') selected @endif>Female</option>
                                                    <option value="Other" @if($data['customers']->gender=='Other') selected @endif>Other</option>
                                              </select>
                                            
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Date of Birth</label>
                                            <div class="col-sm-10 col-md-4">
                                            {!! Form::text('dob',  $data['customers']->dob, array('class'=>'form-control datepicker', 'id'=>'dob')) !!} 
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Status') }}
                                            </label>
                                            <div class="col-sm-10 col-md-4">
                                                <select class="form-control" name="status">
                                                    <option @if($data['customers']->status == 1)
                                                        selected
                                                        @endif
                                                        value="1">{{ trans('labels.Active') }}</option>
                                                    <option @if($data['customers']->status == 0)
                                                        selected
                                                        @endif
                                                        value="0">{{ trans('labels.Inactive') }}</option>
                                                </select><span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.StatusText') }}</span>

                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                        <div class="box-footer text-center">
                                            <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }} </button>
                                            <a href="{{ URL::to('admin/customers/display')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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
        </div>
        <!-- /.row -->

        <!-- Main row -->

        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
@endsection
