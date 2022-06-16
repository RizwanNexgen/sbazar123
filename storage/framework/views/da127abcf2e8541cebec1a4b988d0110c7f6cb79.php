
<?php $__env->startSection('content'); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> <?php echo e(trans('labels.Inventory')); ?> <small><?php echo e(trans('labels.Inventory')); ?>...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo e(URL::to('admin/dashboard/this_month')); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('labels.breadcrumb_dashboard')); ?></a></li>
            <li><a href="<?php echo e(URL::to('admin/products/display')); ?>"><i class="fa fa-database"></i> <?php echo e(trans('labels.ListingAllProducts')); ?></a></li>
            
            <li class="active"><?php echo e(trans('labels.Inventory')); ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <?php if(session()->has('message.level')): ?>
                                    <div class="alert alert-<?php echo e(session('message.level')); ?> alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <?php echo session('message.content'); ?>

                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-info">
                                    <!-- form start -->
                                    <div class="box-body">
                                        
                                        <div class="col-md-12">
                                            <?php echo Form::open(array('url' =>'admin/products/inventory/addnewstock', 'name'=>'inventoryfrom', 'id'=>'addewinventoryfrom', 'method'=>'post', 'class' => 'form-horizontal form-validate',
                                                                        'enctype'=>'multipart/form-data')); ?>

                                            <div class="form-group" >
                                            <label for="name" class="col-sm-2 col-md-2 control-label"><?php echo e(trans('labels.Products')); ?><span style="color:red;">*</span> </label>
                                            <div class="col-sm-6 col-md-6">
                                                <select id="pro_id" class="form-control select2 field-validate product-type" name="products_id">
                                                    <option value=""><?php echo e(trans('labels.Choose Product')); ?></option>
                                                    <?php $__currentLoopData = $result['products']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($pro->products_id); ?>"><?php echo e($pro->products_sku); ?> - <?php echo e($pro->products_name); ?> - <?php echo e($pro->products_weight); ?> <?php echo e($pro->products_weight_unit); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    <?php echo e(trans('labels.Product Type Text')); ?>.
                                                </span>
                                            </div>
                                        </div>
                                    
                                        </div>
                                    
                                        <div class="row" id="form_div" style="display:none">
                                            <!-- Left col -->
                                            <div class="col-md-6">
                                                <!-- MAP & BOX PANE -->

                                                <!-- /.box -->
                                                <div class="row">
                                                    <!-- /.col -->
                                                    <div class="col-md-12">
                                                        <!-- USERS LIST -->
                                                        <div class="box box-info">
                                                            <div class="box-header with-border">
                                                                <h3 class="box-title"><?php echo e(trans('labels.Add Stock')); ?></h3>
                                                                <div class="box-tools">

                                                                </div>
                                                            </div>
                                                            <!-- /.box-header -->
                                                            <div class="box-body">
                                                               

                                                                <div class="form-group">
                                                                    <label for="name" class="col-sm-2 col-md-4 control-label">
                                                                        <?php echo e(trans('labels.Current Stock')); ?>

                                                                    </label>
                                                                    <div class="col-sm-10 col-md-8">
                                                                        
                                                                        <p id="current_stocks_n" style="width:100%">0</p><br>
                                                                    </div>
                                                                </div>

                                                                
                                                                <div class="form-group">
                                                                    <label for="name" class="col-sm-2 col-md-4 control-label"><?php echo e(trans('labels.Enter Stock')); ?><span style="color:red;">*</span></label>
                                                                    <div class="col-sm-10 col-md-8">
                                                                        <input type="text" id="stock_n" name="stock" value="" class="form-control">
                                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                            <?php echo e(trans('labels.Enter Stock Text')); ?></span>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="name" class="col-sm-2 col-md-4 control-label">Enter Min Order<span style="color:red;">*</span></label>
                                                                    <div class="col-sm-10 col-md-8">
                                                                        <input type="text" id="products_min_order" name="products_min_order" value="" class="form-control">
                                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                            Enter Min order</span>
                                                                    </div>
                                                                </div>
                                                             
                                                                <div class="form-group">
                                                                    <label for="name" class="col-sm-2 col-md-4 control-label">Expire Date</label>
                                                                    <div class="col-sm-10 col-md-8">
                                                                        <input class="form-control datepicker field-validate" readonly="" type="text" name="expire_date" id="expire_date">
                                                                    </div>
                                                                </div>
                                                    

                                                                <!-- /.users-list -->
                                                            </div>
                                            

                                            
                                                            <!-- /.box-footer -->
                                                        </div>
                                                        <!--/.box -->
                                                    </div>

                                                    <!-- /.col -->
                                                </div>
                                                <!-- /.row -->

                                                
                                            </div>

                                            <div class="col-md-6" >
                                                <!-- MAP & BOX PANE -->

                                                <!-- /.box -->
                                                <div class="row">
                                                    <!-- /.col -->
                                                    <div class="col-md-12">
                                                        <!-- USERS LIST -->
                                                        <div class="box box-danger">
                                                            <div class="box-header with-border">
                                                                <h3 class="box-title"><?php echo e(trans('labels.Manage Min/Max Quantity')); ?></h3>
                                                            </div>
                                                            <!-- /.box-header -->
                                                            <div class="box-body">
                                                                <div class="form-group">
                                                                    <label for="name" class="col-sm-2 col-md-4 control-label">
                                                                        <?php echo e(trans('labels.Min Level')); ?><span style="color:red;">*</span>
                                                                    </label>
                                                                    <div class="col-sm-10 col-md-8">
                                                                        <input type="text" name="min_level" id="min_level_n" value="" class="form-control number-validate-level">
                                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                            <?php echo e(trans('labels.Min Level Text')); ?></span>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="name" class="col-sm-2 col-md-4 control-label">
                                                                        <?php echo e(trans('labels.Max Level')); ?><span style="color:red;">*</span>
                                                                    </label>
                                                                    <div class="col-sm-10 col-md-8">
                                                                        <input type="text" name="max_level" id="max_level_n" value="" class="form-control number-validate-level">
                                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                            <?php echo e(trans('labels.Max Level Text')); ?></span>
                                                                    </div>
                                                                </div>
                                                                
                                                                <!-- /.users-list -->
                                                            </div>
                                                            <!-- /.box-body -->
                                                            <!-- /.box-footer -->
                                                        </div>
                                                        <!--/.box -->
                                                    </div>

                                                    <!-- /.col -->
                                                </div>
                                                <!-- /.row -->
                                            </div>

                                        </div>
                                        
                                        <div class="row" id="image_div" style="display:none">
                                            <!-- Left col -->
                                            <div class="col-md-12">
                                                
                                                <div class="box box-info">
                                                    
                                                    <div class="box-header with-border">
                                                        <h3 class="box-title">Product Images</h3>
                                                    </div>
                                                    
                                                    <div class="box-body">
                                                        
                                                        <div class="form-group">
                                                            <label for="name" class="col-sm-1 control-label">Main Img</label>
                                                            <div class="col-sm-3">
                                                                <img id="p_main_image" src="" alt="" width=" 100px">
                                                                <input type="file" name="p_main_img">
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <br><br>

                                                    <div class="box-body">
                                                        <div class="form-group">
                                                            <label class="col-sm-1 control-label">Sub Img 1</label>
                                                            <div class="col-sm-3">
                                                                <img id="p_sub_image_1" src="" alt="" width="100px">
                                                                <input type="file" name="p_sub_image_1">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label class="col-sm-1 control-label">Sub Img 2</label>
                                                            <div class="col-sm-3">
                                                                <img id="p_sub_image_2" src="" alt="" width="100px">
                                                                <input type="file" name="p_sub_image_2">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label class="col-sm-1 control-label">Sub Img 3</label>
                                                            <div class="col-sm-3">
                                                                <img id="p_sub_image_3" src="" alt="" width="100px">
                                                                <input type="file" name="p_sub_image_3">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>

                            <?php if(count($result['products'])> 0): ?>
                            <div class="box-footer text-center">
                                <button type="submit" class="btn btn-primary"><?php echo e(trans('labels.Submit')); ?></button>
                            </div>
                            <?php endif; ?>

                            <?php echo Form::close(); ?>

                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.row -->

    <!-- Main row -->
</div>

<!-- /.row -->
<script src="<?php echo asset('admin/plugins/jQuery/jQuery-2.2.0.min.js'); ?>"></script>
<script>

    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();
    
        if (month.length < 2) 
            month = '0' + month;
        if (day.length < 2) 
            day = '0' + day;
    
        return [day, month, year].join('/');
    }
    
    $(document).ready(function(){
       $('#pro_id').change(function(event){

           $('#image_div').show();

            $.ajax({
              method: "POST",
              url: "<?php echo e(url('')); ?>/admin/products/get_single_product/" + $(this).val(),
            })
              .done(function( msg ) {
                  
                //console.log(msg);
                
                $("#p_main_image").attr("src", msg.main_image);
                $("#p_sub_image_1").attr("src", msg.sub_images[0]);
                $("#p_sub_image_2").attr("src", msg.sub_images[1]);
                $("#p_sub_image_3").attr("src", msg.sub_images[2]);
                
                $('#current_stocks_n').html(msg.products_in_stock);
                $('#stock_n').val(msg.products_in_stock);
                $('#min_level_n').val(msg.products_min_stock);
                $('#max_level_n').val(msg.products_max_stock);
                $('#products_min_order').val(msg.products_min_order);
                if(msg.expire_date != null && msg.expire_date != ''){
                    $('#expire_date').datepicker("setDate", new Date(msg.expire_date) );
                }
                
              });
        }); 
    });
    
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/app/current/resources/views/admin/products/inventory/add2.blade.php ENDPATH**/ ?>