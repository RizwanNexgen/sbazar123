@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> {{ trans('labels.Hotcat') }}  <small>{{ trans('labels.EditCurrentHotcat') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li><a href="{{ URL::to('admin/hotcats/display')}}"><i class="fa fa-industry"></i> {{ trans('labels.Hotcat') }}</a></li>
                <li class="active">{{ trans('labels.EditHotcat') }}</li>
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
                            <h3 class="box-title">{{ trans('labels.EditHotcatInfo') }} </h3>
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

                                            
                                            {!! Form::open(array('url' =>'admin/hotcats/update', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                                            {!! Form::hidden('id',  $editHotcat->id , array('class'=>'form-control', 'id'=>'id')) !!}
                                            {!! Form::hidden('oldImage',  $editHotcat->header_image , array('id'=>'oldImage')) !!}
                                            {!! Form::hidden('oldIcon', $editHotcat->logo_image , array('id'=>'oldIcon')) !!}

                                            

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Name') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text('name',  $editHotcat->name , array('class'=>'form-control field-validate', 'id'=>'name'), value(old('name'))) !!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.HotcatNameExample') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">Color Code<span style="color:red;">*</span></label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text('color_code',  $editHotcat->color_code, array('class'=>'form-control  field-validate', 'id'=>'color_code'), value(old('color_code'))) !!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Color(0×FFBFF4B2)</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Status') }} <span style="color:red;">*</span> </label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select class="form-control" name="hotcats_status">
                                                        <option {{ ($editHotcat->status == 1) ? "selected" : "" }} value="1">{{ trans('labels.Active') }}</option>
                                                        <option {{ ($editHotcat->status == 0) ? "selected" : "" }} value="0">{{ trans('labels.Inactive') }}</option>
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                        {{ trans('labels.SelectStatus') }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.slug') }} </label>
                                                <div class="col-sm-10 col-md-4">
                                                    <input type="hidden" name="old_slug" value="{{$editHotcat->slug}}">
                                                    <input type="text" name="slug" class="form-control field-validate" value="{{$editHotcat->slug}}">
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.slugText') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                            </div>

                                            
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">Header Image</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="Modalhotcated" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" id="closemodal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                                    <h3 class="modal-title text-primary" id="myModalLabel">{{ trans('labels.Choose Image') }} </h3>
                                                                </div>
                                                                <div class="modal-body hotcat-image-embed">
                                                                    @if(isset($allimage))
                                                                    <select class="image-picker show-html " name="image_id" id="select_img">
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
                                                                <button type="button" class="btn btn-primary" id="selected" data-dismiss="modal">Done</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {!! Form::button(trans('labels.Add Image'), array('id'=>'newImage','class'=>"btn btn-primary ", 'data-toggle'=>"modal", 'data-target'=>"#Modalhotcated" )) !!}
                                                    <br>
                                                    <div id="selectedthumbnail" class="selectedthumbnail col-md-5"> </div>
                                                    <div class="closimage">
                                                        <button type="button" class="close pull-left image-close " id="image-close"
                                                            style="display: none; position: absolute;left: 105px; top: 54px; background-color: black; color: white; opacity: 2.2; " aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.UploadSubCategoryImage') }}</span>

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label"></label>
                                                <div class="col-sm-10 col-md-4">
                                                <span class="help-block " style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.OldImage') }}</span>
                                                <br>
                                                <img src="{{asset($editHotcat->header_path)}}" alt="" width=" 100px">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">Logo</label>
                                                <div class="col-sm-10 col-md-4">
                                                    {{--{!! Form::file('newIcon', array('id'=>'newIcon')) !!}--}}

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="ModalhotcatedICone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" id="closemodal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                                    <h3 class="modal-title text-primary" id="myModalLabel">{{ trans('labels.Choose Image') }} </h3>
                                                                </div>
                                                                <div class="modal-body hotcat-image-embed">
                                                                    @if(isset($allimage))
                                                                    <select class="image-picker show-html " name="image_icone" id="select_img">
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
                                                                    <button type="button" class="btn btn-primary" id="selectedICONE" data-dismiss="modal">Done</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="imageselected">
                                                        {!! Form::button(trans('labels.Add Icon'), array('id'=>'newIcon','class'=>"btn btn-primary ", 'data-toggle'=>"modal", 'data-target'=>"#ModalhotcatedICone" )) !!}
                                                        <br>
                                                        <div id="selectedthumbnailIcon" class="selectedthumbnail col-md-5"> </div>
                                                        <div class="closimage">
                                                            <button type="button" class="close pull-left image-close " id="image-Icone"
                                                            style="display: none; position: absolute;left: 105px; top: 54px; background-color: black; color: white; opacity: 2.2; " aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.UploadSubCategoryIcon') }}</span>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label"></label>
                                                <div class="col-sm-10 col-md-4">
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.OldImage') }}</span>
                                                    <br>
                                                    <img src="{{asset($editHotcat->logo_path)}}" alt="" width=" 100px">

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
                                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Description') }}@if($languages->code=='en') <span style="color:red;">*</span> @endif ({{ $languages->name }})</label>
                                                                    <div class="col-sm-10 col-md-8">
                                                                        <textarea id="editor<?=$languages->languages_id?>" name="brand_description_<?=$languages->languages_id?>" class="form-control" rows="5">{{$editHotcat->infos[$languages->languages_id]->hotcats_desc}}</textarea>
                                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                            {{ trans('labels.EnterProductDetailIn') }} {{ $languages->name }}</span>
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
                                                <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                                <a href="{{ URL::to('admin/hotcats/display')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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
    </script>
@endsection
