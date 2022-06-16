@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Bundles <small>Edit Bundle...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li><a href="{{ URL::to('admin/bundles/display')}}"><i class="fa fa-industry"></i> Bundles</a></li>
                <li class="active">Edit Bundle</li>
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
                            <h3 class="box-title">Edit bundle</h3>
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


                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul class="mb-0">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                    <!-- /.box-header -->
                                        <!-- form start -->
                                        <div class="box-body">
                                            <form action="" method="POST">
                                            @csrf                                        
                                            <div class="form-group">
                                                <label>Bundle Type</label>
                                                <select name="bundle_type" class="form-control">
                                                    <option value="1" @if($info->bundle_type==1) selected @endif>Price</option>
                                                    <option value="2" @if($info->bundle_type==2) selected @endif>Point</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="1" @if($info->status==1) selected @endif>Active</option>
                                                    <option value="0" @if($info->status==0) selected @endif>Inactive</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Discount%</label>
                                                <input type="text" class="form-control" name="discount" value="{{$info->discount}}" />
                                            </div>
                                            <div class="form-group">
                                                <label>Points</label>
                                                <input type="text" class="form-control" name="points" value="{{$info->points}}" />
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>MSD ?</label>
                                                <select class="form-control" name="has_msd" onChange="toggleMSD(this.value)">
                                                    <option value="N" @if($info->has_msd=='N') selected @endif>No</option>
                                                    <option value="Y" @if($info->has_msd=='Y') selected @endif>Yes</option>
                                                </select>
                                            </div>
                                            <div id="msd_fields" style="display:@if($info->has_msd=='N') none @else block @endif ;">
                                                <div class="row">
                                                    @foreach($bundles_msd as $msd)
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <label>{{$msd->level_title}}</label>
                                                                <input type="text" class="form-control" name="level_discount_{{$msd->level_id}}" value="{{$msd->discount}}" />
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="form-group" id="imageIcone">
                                                
                                                <div class="col-sm-">
                                                    <!-- Modal -->
                                                    <div class="modal fade embed-images" id="ModalmanufacturedICone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" id="closemodal" aria-label="Close"><span aria-hidden="true"></span></button>
                                                                    <h3 class="modal-title text-primary" id="myModalLabel">{{ trans('labels.Choose Image') }} </h3>
                                                                </div>
                                                                <div class="modal-body manufacturer-image-embed">
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
                                                                    <button type="button" class="btn btn-success" id="selectedICONE" data-dismiss="modal">{{ trans('labels.Done') }}</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="imageselected">
                                                      {!! Form::button('Background Image', array('id'=>'newIcon','class'=>"btn btn-primary", 'data-toggle'=>"modal", 'data-target'=>"#ModalmanufacturedICone" )) !!}
                                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Upload logo after header image</span>
                                                      <br>
                                                      <div id="selectedthumbnailIcon" class="selectedthumbnail col-md-5"> </div>
                                                      <div class="closimage">
                                                          <button type="button" class="close pull-left image-close " id="image-Icone"
                                                            style="display: none; position: absolute;left: 105px; top: 54px; background-color: black; color: white; opacity: 2.2; " aria-label="Close">
                                                              <span aria-hidden="true">&times;</span>
                                                          </button>
                                                      </div>
                                                    </div>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.ImageText') }}</span>

                                                    <br>
                                                </div>
                                            </div>

                                            

                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="tabbable tabs-left">
                                                        <ul class="nav nav-tabs">
                                                            @foreach($bundles_info as $key=>$bundle_info)
                                                            <li class="@if($key==0) active @endif"><a href="#product_{{$bundle_info->language_id}}" data-toggle="tab">{{$bundle_info->name}}</a></li>
                                                            @endforeach
                                                        </ul>
                                                        <div class="tab-content">
                                                            @foreach($bundles_info as $key=>$bundle_info)
                                                            <div style="margin-top: 15px;" class="tab-pane @if($key==0) active @endif" id="product_{{$bundle_info->language_id}}">
                                                                <div class="form-group">
                                                                    <label>Bundle Title</label>
                                                                    <input type="text" class="form-control" name="bundle_title_{{$bundle_info->language_id}}" value="{{$bundle_info->bundle_title}}" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Bundle TOS</label>
                                                                    <textarea class="form-control" name="bundle_tos_{{$bundle_info->language_id}}">{{$bundle_info->bundle_tos}}</textarea>
                                                                </div>
                                                            </div>
                                                            @endforeach 

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- /.box-body -->
                                            <div class="box-footer">
                                                <button type="submit" class="btn btn-primary">{{ trans('labels.submit') }}</button>
                                                <a href="{{ URL::to('admin/bundles/display')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
                                            </div>
                                            <!-- /.box-footer -->
                                            </form>
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

        function toggleMSD(option)
        {
            if(option=='Y')
            {
                $('#msd_fields').show();
            }
            else
            {
                $('#msd_fields').hide();
            }
        }
    </script>
@endsection
