
<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> <?php echo e(trans('labels.Categories')); ?> <small><?php echo e(trans('labels.AddCategories')); ?>...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo e(URL::to('admin/dashboard/this_month')); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('labels.breadcrumb_dashboard')); ?></a></li>
            <li><a href="<?php echo e(URL::to('admin/categories/display')); ?>"><i class="fa fa-database"></i><?php echo e(trans('labels.Categories')); ?></a></li>
            <li class="active"><?php echo e(trans('labels.AddCategory')); ?></li>
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
                        <h3 class="box-title"><?php echo e(trans('labels.AddCategories')); ?> </h3>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-info">
                                    <!-- form start -->
                                    <br>
                                    <?php if(count($errors) > 0): ?>
                                    <?php if($errors->any()): ?>
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <?php echo e($errors->first()); ?>

                                    </div>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                    <div class="box-body">

                                        <?php echo Form::open(array('url' =>'admin/categories/add', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')); ?>

                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.Category')); ?></label>
                                            <div class="col-sm-10 col-md-4">
                                                <select class="form-control" name="parent_id">
                                                    <?php echo e(print_r($result['categories'])); ?>

                                                </select>
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    <?php echo e(trans('labels.ChooseMainCategory')); ?></span>
                                            </div>
                                        </div>

                                        <?php $__currentLoopData = $result['languages']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $languages): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.Name')); ?><?php if($languages->code=='en'): ?> <span style="color:red;">*</span> <?php endif; ?></label>
                                            <div class="col-sm-10 col-md-4">
                                                <input name="categoryName_<?=$languages->languages_id?>" class="form-control <?php if($languages->code=='en'): ?> field-validate <?php endif; ?>">
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    <?php echo e(trans('labels.SubCategoryName')); ?> (<?php echo e($languages->name); ?>).</span>
                                                <span class="help-block hidden"><?php echo e(trans('labels.textRequiredFieldMessage')); ?></span>
                                            </div>
                                        </div>
 
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.Description')); ?> (<?php echo e($languages->name); ?>) </label>
                                            <div class="col-sm-10 col-md-6">
                                              <textarea id="editor<?=$languages->languages_id?>" name="description_<?=$languages->languages_id?>" class="form-control" rows="10" cols="80"></textarea>
                                              <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;"><?php echo e(trans('labels.Description')); ?> (<?php echo e($languages->name); ?>)</span>
      
                                              <br>
                                            </div>
                                        </div>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        <div class="form-group" id="imageselected">
                                            <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.Image')); ?><span style="color:red;">*</span></label>
                                            
                                            <div class="col-sm-3">
                                                <input type="file" name="cat_img">
                                            </div>

                                            
                                        </div>

                                        <div class="form-group" id="imageIcone">

                                            <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.Icon')); ?><span style="color:red;">*</span></label>
                                            

                                            <div class="col-sm-3">
                                                <input type="file" name="cat_icon">
                                            </div>

                                        </div>

                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label"><?php echo e(trans('labels.Status')); ?> </label>
                                          <div class="col-sm-10 col-md-4">
                                            <select class="form-control" name="categories_status">
                                                  <option value="1"><?php echo e(trans('labels.Active')); ?></option>
                                                  <option value="0"><?php echo e(trans('labels.Inactive')); ?></option>
                                            </select>
                                          <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                          <?php echo e(trans('labels.GeneralStatusText')); ?></span>
                                          </div>
                                        </div>

                                        <!-- /.box-body -->
                                        <div class="box-footer text-center">
                                            <button type="submit" class="btn btn-primary"><?php echo e(trans('labels.Submit')); ?></button>
                                            <a href="<?php echo e(URL::to('admin/categories/display')); ?>" type="button" class="btn btn-default"><?php echo e(trans('labels.back')); ?></a>
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
        </div>
        <!-- /.row -->

        <!-- Main row -->

        <!-- /.row -->
    </section>
    <!-- /.content -->

</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/app/current/resources/views/admin/categories/add.blade.php ENDPATH**/ ?>