
<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Flash Deals <small>Flash Deals...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo e(URL::to('admin/dashboard/this_month')); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('labels.breadcrumb_dashboard')); ?></a></li>
            <li class="active">Flash Deals</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Flash Deals</h3>
                    </div>
                    
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-info">
                                    <div class="box-body">
                                        <?php if( count($errors) > 0): ?>
                                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="alert alert-success" role="alert">
                                            <span class="icon fa fa-check" aria-hidden="true"></span>
                                            <span class="sr-only">Flash Deals Error:</span>
                                            <?php echo e($error); ?>

                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>

                                        <?php echo Form::open(array('url' =>'admin/update-flash-deals', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')); ?>

                                        <br>


                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Enable</label>
                                            <div class="col-sm-10 col-md-4">
                                                <select class="form-control" name="status">
                                                    <option <?php echo e(($list->status == 1) ? "selected" : ""); ?> value="1">Yes</option>
                                                    <option <?php echo e(($list->status == 0) ? "selected" : ""); ?> value="0">No</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Start Time</label>
                                            <div class="col-sm-10 col-md-4">
                                                <input class="form-control datepicker field-validate" readonly="" type="text" name="flash_start_date" id="flash_start_date" value="<?php echo e(date('d/m/Y',strtotime($list->start_time))); ?>">
                                            </div>
                                            <div class="col-sm-10 col-md-4 bootstrap-timepicker"><div class="bootstrap-timepicker-widget dropdown-menu"><table><tbody><tr><td><a href="#" data-action="incrementHour"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td class="meridian-column"><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a></td></tr><tr><td><span class="bootstrap-timepicker-hour">09</span></td> <td class="separator">:</td><td><span class="bootstrap-timepicker-minute">00</span></td> <td class="separator">&nbsp;</td><td><span class="bootstrap-timepicker-meridian">PM</span></td></tr><tr><td><a href="#" data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator"></td><td><a href="#" data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-down"></i></a></td></tr></tbody></table></div>
                                                <input type="text" class="form-control timepicker" name="flash_start_time" readonly="" id="flash_start_time" value="<?php echo e(date('H:i',strtotime($list->start_time))); ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">End Time</label>
                                            <div class="col-sm-10 col-md-4">
                                                <input class="form-control datepicker field-validate" readonly="" type="text" name="flash_end_date" id="flash_start_date" value="<?php echo e(date('d/m/Y',strtotime($list->end_time))); ?>">
                                            </div>
                                            <div class="col-sm-10 col-md-4 bootstrap-timepicker"><div class="bootstrap-timepicker-widget dropdown-menu"><table><tbody><tr><td><a href="#" data-action="incrementHour"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td class="meridian-column"><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a></td></tr><tr><td><span class="bootstrap-timepicker-hour">09</span></td> <td class="separator">:</td><td><span class="bootstrap-timepicker-minute">00</span></td> <td class="separator">&nbsp;</td><td><span class="bootstrap-timepicker-meridian">PM</span></td></tr><tr><td><a href="#" data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator"></td><td><a href="#" data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-down"></i></a></td></tr></tbody></table></div>
                                                <input type="text" class="form-control timepicker" name="flash_end_time" readonly="" id="flash_end_time" value="<?php echo e(date('H:i',strtotime($list->end_time))); ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label"> Number of Products </label>
                                            <div class="col-sm-10 col-md-4">
                                                <label> <?php echo e(count($list->products)); ?> Products</label>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <?php if(count($list->products) > 0): ?>
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Products </label>
                                            <div class="col-sm-12 col-md-8">
                                                <a class="btn btn-primary" href="<?php echo e(url('admin/flash-deals/products')); ?>">Add Product</a>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <br>
                                        <br>
                                        
                                        <div id="productList" class="form-group">
                                            <?php if(count($list->products) > 0): ?>
                                            <div class="col-sm-10 col-md-8 col-sm-offset-2">
                                                <div class="card">
                                                    <table class="table">
                                                        <tr>
                                                            <th width="10%" style="vertical-align:middle; text-align:center;">#ID</th>
                                                            <th width="10%" style="vertical-align:middle; text-align:center;">#Image</th>
                                                            <th width="30%" style="vertical-align:middle; text-align:center;">#Name</strong></th>
                                                            <th width="20%" style="vertical-align:middle; text-align:center;">#Actual Price</th>
                                                            <th width="15%" style="vertical-align:middle; text-align:center;">#Flash Deals Price</th>
                                                            <th width="15%" style="vertical-align:middle; text-align:center;">#Action</th>
                                                        </tr>
                                                        <?php $__currentLoopData = $list->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td width="10%" style="vertical-align:middle; text-align:center;">#<?php echo e($p->products_id); ?></td>
                                                            <td width="10%" style="vertical-align:middle; text-align:center;"><img src="<?php echo e(asset($p->path)); ?>" class="img-thumbnail" alt="" height="50px"></td>
                                                            <td width="30%" style="vertical-align:middle; text-align:center;"><strong><?php echo e($p->products_name); ?></strong></td>
                                                            <td width="20%" style="vertical-align:middle; text-align:center;"><?php echo e($p->products_price); ?></td>
                                                            <td width="15%" style="vertical-align:middle; text-align:center;">
                                                                <input hidden value="<?php echo e($p->products_id); ?>" name="product_id[]">
                                                                <input type="text" name="product_ss[]" value=<?php echo e($p->new_product_price); ?>>
                                                            </td>
                                                            <td width="15%" style="vertical-align:middle; text-align:center;">
                                                                <a class="btn btn-sm btn-danger" href="<?php echo e(url('admin/super-deals/remove_products')); ?>/<?php echo e($p->products_id); ?>" >Remove</a>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        
                                                    </table>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                        
                                    </div>

                                    <!-- /.box-body -->
                                    <div class="box-footer text-center">
                                        <button type="submit" class="btn btn-primary"><?php echo e(trans('labels.Submit')); ?> </button>
                                        <a href="<?php echo e(URL::to('admin/dashboard/this_month')); ?>" type="button" class="btn btn-default"><?php echo e(trans('labels.back')); ?></a>
                                    </div>

                                    <!-- /.box-footer -->
                                    <?php echo Form::close(); ?>

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
<script>
    function toggleProductList(e){
        $('#productList').toggle();
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/app/current/resources/views/admin/flash_deals/index.blade.php ENDPATH**/ ?>