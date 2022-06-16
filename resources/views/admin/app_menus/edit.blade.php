@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Menubar <small>Edit Menu...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li><a href="{{ URL::to('admin/appmenus/display')}}"><i class="fa fa-gears"></i> Menubar</a></li>
            <li class="active">Edit Menu</li>
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
                        <h3 class="box-title">Edit Menu </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-info">
                                    
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
                                        <form action="" method="POST" enctype="multipart/form-data">
                                        @csrf    
                                            <div class="form-group">
                                                <label>Background or Icon</label>
                                                <input type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" />
                                                @if($info->menu_type=='Main' && !empty($info->bg_image))
                                                <p class="help-block">{{asset('storage/app/backgrounds/'.$info->bg_image)}}</p>
                                                @elseif($info->menu_type=='Bottom' && !empty($info->icon))
                                                <p class="help-block">{{asset('storage/app/icons/'.$info->icon)}}</p>
                                                @endif

                                                @error('photo')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>URL</label>                                                
                                                <input type="text" class="form-control @error('photo') is-invalid @enderror" value="{{$info->url}}" name="url" />                                                
                                                @error('url')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Type</label>
                                                <select name="menu_type" class="form-control">
                                                    <option value="Main" @if($info->menu_type=='Main') selected @endif>Main</option>
                                                    <option value="Bottom" @if($info->menu_type=='Bottom') selected @endif>Bottom</option>
                                                </select>
                                            </div>
                                            @foreach($result['languages'] as $key=>$languages)
                                            <div class="form-group">
                                                <label>Title ({{$languages->name}})</label>                                                
                                                <input type="text" class="form-control @error('title_'.$languages->languages_id) is-invalid @enderror" value="@if(!empty($app_menus_langs[$languages->languages_id]->id)) {{$app_menus_langs[$languages->languages_id]->title}} @endif" name="title_{{$languages->languages_id}}" />                                                
                                                @error('title_'.$languages->languages_id)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            @endforeach

                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">Submit</button>
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
