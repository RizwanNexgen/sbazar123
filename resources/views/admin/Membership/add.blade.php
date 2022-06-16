@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Membership <small>Add New Membership...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li><a href="{{ URL::to('admin/memberships/display')}}"><i class="fa fa-industry"></i> Membership</a></li>
                <li class="active">{{ trans('labels.AddManufacturer') }}</li>
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
                            <h3 class="box-title">Add New Membership </h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box box-info">
                                        <br>

                                        @if (session('update'))
                                            <div class="alert alert-success alert-dismissable custom-success-box" style="margin: 15px;">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <strong> {{ session('update') }} </strong>
                                            </div>
                                        @endif


                                        @if (count($errors) > 0)
                                            @if($errors->any())
                                                <div class="alert alert-danger alert-dismissible" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    {{$errors->first()}}
                                                </div>
                                        @endif
                                    @endif
                                    <!-- /.box-header -->
                                        <!-- form start -->
                                        <div class="box-body">
                                            {!! Form::open(array('url' =>'admin/memberships/add', 'method'=>'post', 'class' => 'form-horizontal form-validate ', 'enctype'=>'multipart/form-data')) !!}

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Name') }}<span style="color:red;">*</span></label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text('name',  '', array('class'=>'form-control  field-validate', 'id'=>'name'), value(old('name'))) !!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Membership Name</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                            </div>
 
                                            
                                            <div class="form-group" id="imageselected">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">Image<span style="color:red;">*</span></label>
                                                <div class="col-sm-10 col-md-4">
                                                    {{--{!! Form::file('newImage', array('id'=>'newImage')) !!}--}}
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="Modalmanufactured" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" id="closemodal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                                    <h3 class="modal-title text-primary" id="myModalLabel">Choose Image</h3>
                                                                </div>
                                                                <div class="modal-body manufacturer-image-embed">
                                                                    @if(isset($allimage))
                                                                    <select class="image-picker show-html field-validate" name="image_id" id="select_img">
                                                                        <option value=""></option>
                                                                        @foreach($allimage as $key=>$image)
                                                                        <option data-img-src="{{asset($image->path)}}" class="imagedetail" data-img-alt="{{$key}}" value="{{$image->id}}"> {{$image->id}} </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @endif
                                                                </div>
                                                                <div class="modal-footer">
                                                                <a href="{{url('admin/media/add')}}" target="_blank" class="btn btn-primary pull-left" >{{ trans('labels.Add Image') }}</a>
                                                                <button type="button" class="btn btn-default refresh-image"><i class="fa fa-refresh"></i></button>
                                                                <button type="button" class="btn btn-primary" id="selected" data-dismiss="modal">{{ trans('labels.Done') }}</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="imageselected">
                                                        {!! Form::button(trans('labels.Add Image'), array('id'=>'newImage','class'=>"btn btn-primary field-validate", 'data-toggle'=>"modal", 'data-target'=>"#Modalmanufactured" )) !!}
                                                        <br>
                                                        <div id="selectedthumbnail" class="selectedthumbnail col-md-5"> </div>
                                                        <div class="closimage">
                                                            <button type="button" class="close pull-left image-close " id="image-close"
                                                            style="display: none; position: absolute;left: 105px; top: 54px; background-color: black; color: white; opacity: 2.2; " aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.CategoryImageText') }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">Points Level<span style="color:red;">*</span></label>
                                                <div class="col-sm-5 col-md-2">
                                                    {!! Form::number('membership_points_from',  '', array('class'=>'form-control  field-validate', 'id'=>'membership_points_from'), value(old('membership_points_from'))) !!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Points From</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                                <div class="col-sm-5 col-md-2">
                                                    {!! Form::number('membership_points_to',  '', array('class'=>'form-control  field-validate', 'id'=>'membership_points_to'), value(old('membership_points_to'))) !!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Points To</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">Discount Percentage<span style="color:red;">*</span></label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::number('membership_discount_percentage',  '', array('class'=>'form-control  field-validate', 'id'=>'membership_discount_percentage'), value(old('membership_discount_percentage'))) !!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Enter discount percentage</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">Cap Value<span style="color:red;">*</span></label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::number('membership_cap_value',  '', array('class'=>'form-control  field-validate', 'id'=>'membership_cap_value'), value(old('membership_cap_value'))) !!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Enter cap value</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="membership_has_validity" class="col-sm-2 col-md-3 control-label">Validity<span style="color:red;">*</span> </label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select class="form-control" id="membership_has_validity" name="membership_has_validity">
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Select Validity</span>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="membership_valid_till" id="membership_valid_till_label" class="col-sm-2 col-md-3 control-label">Membership Valid Till<span style="color:red;">*</span></label>
                                                <div class="col-sm-10 col-md-4">
                                                    <input autocomplete="OFF" type="text" class="form-control field-validate form_datetime" id="membership_valid_till" name="membership_valid_till" value="{{old('membership_valid_till')}}" />
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Select a date</span>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="tabbable tabs-left">
                                                        <ul class="nav nav-tabs">
                                                            @foreach($result['languages'] as $key=>$languages)
                                                            <li class="@if($key==0) active @endif"><a href="#product_<?=$languages->languages_id?>" data-toggle="tab"><?=$languages->name?>@if($languages->code=='en') <span style="color:red;">*</span> @endif</a></li>
                                                            @endforeach
                                                        </ul>
                                                        <div class="tab-content">
                                                            @foreach($result['languages'] as $key=>$languages)

                                                            <div style="margin-top: 15px;" class="tab-pane @if($key==0) active @endif" id="product_<?=$languages->languages_id?>">
                                                                <div class="form-group">
                                                                    <label for="name" class="col-sm-2 col-md-3 control-label">Membership Benifits @if($languages->code=='en') <span style="color:red;">*</span> @endif ({{ $languages->name }})</label>
                                                                    <div class="col-sm-10 col-md-8">
                                                                        <textarea id="editor<?=$languages->languages_id?>" name="benifit_description_<?=$languages->languages_id?>" class="form-control" rows="5"></textarea>
                                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                            Enter Membership Benifits in Detail {{ $languages->name }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach 

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- /.box-body -->
                                            <div class="box-footer text-center">
                                                <button type="submit" class="btn btn-primary">{{ trans('labels.submit') }}</button>
                                                <a href="{{ URL::to('admin/memberships/display')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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

    <script src="{!! asset('admin/plugins/jQuery/jQuery-2.2.0.min.js') !!}"></script>
    <script type="text/javascript">
        $(function() {

            //for multiple languages
            @foreach($result['languages'] as $languages)
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace('editor{{$languages->languages_id}}');

            @endforeach

            //bootstrap WYSIHTML5 - text editor
            $(".textarea").wysihtml5();

        });
        
        $('#membership_has_validity').change(function(){
            if($(this).val() == "0"){
                $("#membership_valid_till").prop("disabled", true);
                $("#membership_valid_till_label").html("Membership Valid Till");
                $("#membership_valid_till").removeClass("field-validate");
            }
            else{
                $("#membership_valid_till_label").html("Membership Valid Till" + "<span style='color:red;'>*</span>");
                $("#membership_valid_till").addClass("field-validate");
                $("#membership_valid_till").prop("disabled", false);
            }
        });
    </script>
@endsection
