
<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Super Deals <small>Super Deals...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo e(URL::to('admin/dashboard/this_month')); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('labels.breadcrumb_dashboard')); ?></a></li>
            <li class="active">Super Deals</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Super Deals</h3>
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
                                            <span class="sr-only">Super Deals Error:</span>
                                            <?php echo e($error); ?>

                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>

                                        <?php echo Form::open(array('url' =>'admin/update-super-deals', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')); ?>

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
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Type</label>
                                            <div class="col-sm-10 col-md-4">
                                                <select class="form-control" name="type">
                                                    <option <?php echo e(($list->type == 'price') ? "selected" : ""); ?> value="price">Price</option>
                                                    <option <?php echo e(($list->type == 'point') ? "selected" : ""); ?> value="point">Point</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Cap Amount</label>
                                            <div class="col-sm-10 col-md-4">
                                                <input type="number" class="form-control" name="cap_amount" value= <?php echo e($list->cap_amount); ?> step="any" />
                                            </div>
                                        </div>

                                        <div class="form-group" id="imageIcone">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Header Image</label>
                                            <div class="col-sm-10 col-md-4">
                                                <!-- Modal -->
                                                <div class="modal fade embed-images" id="ModalmanufacturedICone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" id="closemodal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                                <h3 class="modal-title text-primary" id="myModalLabel"><?php echo e(trans('labels.Choose Image')); ?> </h3>
                                                            </div>
                                                            <div class="modal-body manufacturer-image-embed">
                                                                <?php if(isset($allimage)): ?>
                                                                <select class="image-picker show-html " name="bg_image_id" id="select_img">
                                                                    <option value=""></option>
                                                                    <?php $__currentLoopData = $allimage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option data-img-src="<?php echo e(asset($image->path)); ?>" class="imagedetail" data-img-alt="<?php echo e($key); ?>" value="<?php echo e($image->id); ?>"> <?php echo e($image->id); ?> </option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a href="<?php echo e(url('admin/media/add')); ?>" target="_blank" class="btn btn-primary pull-left"><?php echo e(trans('labels.Add Image')); ?></a>
                                                                <button type="button" class="btn btn-default refresh-image"><i class="fa fa-refresh"></i></button>
                                                                <button type="button" class="btn btn-success" id="selectedICONE" data-dismiss="modal"><?php echo e(trans('labels.Done')); ?></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="imageselected">
                                                    <?php echo Form::button(trans('labels.Add Image'), array('id'=>'newIcon','class'=>"btn btn-primary field-validate", 'data-toggle'=>"modal", 'data-target'=>"#ModalmanufacturedICone" )); ?>

                                                    <br>
                                                    <div id="selectedthumbnailIcon" class="selectedthumbnail col-md-5" style="display: none"> </div>
                                                    <div class="closimage">
                                                        <button type="button" class="close pull-left image-close " id="image-Icone" style="display: none; position: absolute;left: 105px; top: 54px; background-color: black; color: white; opacity: 2.2; " aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                </div>

                                                <br>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">  </label>
                                            <div class="col-sm-10 col-md-4">
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;"><?php echo e(trans('labels.OldImage')); ?></span>
                                                <br>
                                                <?php echo Form::hidden('oldImage',  $result['commonContent']['setting']['website_logo'] , array('id'=>'website_logo')); ?>

                                                <img src="<?php echo e(asset($list->image_category->path)); ?>" alt="" width="80px">
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
                                                <a class="btn btn-primary" href="<?php echo e(url('admin/super-deals/products')); ?>">Add Product</a>
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
                                                            <th width="20%" style="vertical-align:middle; text-align:center;">#Actual Point</th>
                                                            <th width="15%" style="vertical-align:middle; text-align:center;">#Super Deals Price/Point</th>
                                                            <th width="15%" style="vertical-align:middle; text-align:center;">#Action</th>
                                                        </tr>
                                                        <?php $__currentLoopData = $list->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td width="10%" style="vertical-align:middle; text-align:center;">#<?php echo e($p->products_id); ?></td>
                                                            <td width="10%" style="vertical-align:middle; text-align:center;"><img src="<?php echo e(asset($p->path)); ?>" class="img-thumbnail" alt="" height="50px"></td>
                                                            <td width="30%" style="vertical-align:middle; text-align:center;"><strong><?php echo e($p->products_name); ?></strong></td>
                                                            <td width="20%" style="vertical-align:middle; text-align:center;">€<?php echo e($p->products_price); ?></td>
                                                            <td width="20%" style="vertical-align:middle; text-align:center;"><?php echo e($p->products_points); ?> pt</td>
                                                            <td width="15%" style="vertical-align:middle; text-align:center;">
                                                                <input hidden value="<?php echo e($p->products_id); ?>" name="product_id[]">
                                                                <!--<input type="number" class="form-control" name="cap_amount" value= <?php echo e($list->cap_amount); ?> step="any" />-->
                                                                <input type="text" name="product_ss[]" value=<?php echo e(($list->type == 'price') ? $p->new_product_price : $p->new_point); ?>>
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
<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/app/current/resources/views/admin/super_deals/index.blade.php ENDPATH**/ ?>