@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Shipping Methods <small>{{ trans('labels.Setting') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li><a href="{{ URL::to("admin/shippingmethods/display")}}"><i class="fa fa-dashboard"></i>{{ trans('labels.ShippingMethods') }}</a></li>
                <li class="active">DHL</li>
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
                            <h3 class="box-title">DHL</h3>
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
                                    <div class="box box-info">
                                        <!-- form start -->
                                        <div class="box-body">
                                            {!! Form::open(array('url' =>'admin/shippingmethods/updateShippingDhl', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                                            {!! Form::hidden('id',  $result['dhl']->id, array('class'=>'form-control', 'id'=>'id'))!!}
                                            {!! Form::hidden('table_name',  $result['shipping_methods'][0]->table_name , array('class'=>'form-control', 'id'=>'table_name')) !!}
                                            @foreach($result['description'] as $description_data)
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Name') }} ({{ $description_data['language_name'] }})</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="name_<?=$description_data['languages_id']?>" class="form-control field-validate" value="{{$description_data['name']}}">
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.ShippingmethodName') }} ({{ $description_data['language_name'] }}).</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>

                                            @endforeach
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">Free shipping on minimum price</label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text('min_price_for_free',  $result['dhl']->min_price_for_free, array('class'=>'form-control', 'id'=>'min_price_for_free'))!!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    Free shipping on minimum amount
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Currency') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text('currency',  $result['dhl']->currency, array('class'=>'form-control', 'id'=>'currency'))!!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                      {{ trans('labels.CurrencyText') }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">Includes Countries</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select id="country_includes" name="country_includes[]" class="form-control select2" multiple>
                                                        <option value="" disabled>--Select--</option>
                                                        @foreach($result['countries'] as $country)
                                                        <option value="{{$country->countries_iso_code_2}}" @if(@in_array($country->countries_iso_code_2, explode(',', $result['dhl']->country_includes))) selected @endif>{{$country->countries_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                      Select multiple countries</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Status') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="status" class="form-control select2">
                                                        <option @if($result['shipping_methods'][0]->status == 1) selected @endif value="1" >
                                                            {{ trans('labels.Active') }} </option>
                                                        <option @if($result['shipping_methods'][0]->status == 0) selected @endif value="0"> {{ trans('labels.InActive') }}</option>
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                      {{ trans('labels.FlateRateStatus') }}</span>
                                                </div>
                                            </div>

                                            <!-- /.box-body -->
                                            <div class="box-footer text-center">
                                                <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }} </button>
                                                <a href="{{ URL::to("admin/shippingmethods/display")}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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
