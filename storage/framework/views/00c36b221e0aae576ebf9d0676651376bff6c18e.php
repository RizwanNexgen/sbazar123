
<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Bundles <small>Edit Bundle...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo e(URL::to('admin/dashboard/this_month')); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('labels.breadcrumb_dashboard')); ?></a></li>
                <li><a href="<?php echo e(URL::to('admin/bundles/display')); ?>"><i class="fa fa-industry"></i> Bundles</a></li>
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

                                        <?php if(session('update')): ?>
                                            <div class="alert alert-success alert-dismissable custom-success-box" style="margin: 15px;">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <strong> <?php echo e(session('update')); ?> </strong>
                                            </div>
                                        <?php endif; ?>


                                        <?php if($errors->any()): ?>
                                            <div class="alert alert-danger">
                                                <ul class="mb-0">
                                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li><?php echo e($error); ?></li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>

                                    <!-- /.box-header -->
                                        <!-- form start -->
                                        <div class="box-body">
                                            <form action="" method="POST">
                                            <?php echo csrf_field(); ?>                                        
                                            <div class="form-group">
                                                <label>Bundle Type</label>
                                                <select name="bundle_type" class="form-control">
                                                    <option value="1" <?php if($info->bundle_type==1): ?> selected <?php endif; ?>>Price</option>
                                                    <option value="2" <?php if($info->bundle_type==2): ?> selected <?php endif; ?>>Point</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="1" <?php if($info->status==1): ?> selected <?php endif; ?>>Active</option>
                                                    <option value="0" <?php if($info->status==0): ?> selected <?php endif; ?>>Inactive</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Discount%</label>
                                                <input type="text" class="form-control" name="discount" value="<?php echo e($info->discount); ?>" />
                                            </div>
                                            <div class="form-group">
                                                <label>Points</label>
                                                <input type="text" class="form-control" name="points" value="<?php echo e($info->points); ?>" />
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>MSD ?</label>
                                                <select class="form-control" name="has_msd" onChange="toggleMSD(this.value)">
                                                    <option value="N" <?php if($info->has_msd=='N'): ?> selected <?php endif; ?>>No</option>
                                                    <option value="Y" <?php if($info->has_msd=='Y'): ?> selected <?php endif; ?>>Yes</option>
                                                </select>
                                            </div>
                                            <div id="msd_fields" style="display:<?php if($info->has_msd=='N'): ?> none <?php else: ?> block <?php endif; ?> ;">
                                                <div class="row">
                                                    <?php $__currentLoopData = $bundles_msd; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <label><?php echo e($msd->level_title); ?></label>
                                                                <input type="text" class="form-control" name="level_discount_<?php echo e($msd->level_id); ?>" value="<?php echo e($msd->discount); ?>" />
                                                            </div>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                                                    <h3 class="modal-title text-primary" id="myModalLabel"><?php echo e(trans('labels.Choose Image')); ?> </h3>
                                                                </div>
                                                                <div class="modal-body manufacturer-image-embed">
                                                                    <?php if(isset($allimage)): ?>
                                                                    <select class="image-picker show-html " name="image_id" id="select_img">
                                                                        <option value=""></option>
                                                                        <?php $__currentLoopData = $allimage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                          <option data-img-src="<?php echo e(asset($image->path)); ?>" class="imagedetail" data-img-alt="<?php echo e($key); ?>" value="<?php echo e($image->id); ?>"> <?php echo e($image->id); ?> </option>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </select>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <a href="<?php echo e(url('admin/media/add')); ?>" target="_blank" class="btn btn-primary pull-left" ><?php echo e(trans('labels.Add Image')); ?></a>
                                                                    <button type="button" class="btn btn-default refresh-image"><i class="fa fa-refresh"></i></button>
                                                                    <button type="button" class="btn btn-success" id="selectedICONE" data-dismiss="modal"><?php echo e(trans('labels.Done')); ?></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="imageselected">
                                                      <?php echo Form::button('Background Image', array('id'=>'newIcon','class'=>"btn btn-primary", 'data-toggle'=>"modal", 'data-target'=>"#ModalmanufacturedICone" )); ?>

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
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;"><?php echo e(trans('labels.ImageText')); ?></span>

                                                    <br>
                                                </div>
                                            </div>

                                            

                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="tabbable tabs-left">
                                                        <ul class="nav nav-tabs">
                                                            <?php $__currentLoopData = $bundles_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$bundle_info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <li class="<?php if($key==0): ?> active <?php endif; ?>"><a href="#product_<?php echo e($bundle_info->language_id); ?>" data-toggle="tab"><?php echo e($bundle_info->name); ?></a></li>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </ul>
                                                        <div class="tab-content">
                                                            <?php $__currentLoopData = $bundles_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$bundle_info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div style="margin-top: 15px;" class="tab-pane <?php if($key==0): ?> active <?php endif; ?>" id="product_<?php echo e($bundle_info->language_id); ?>">
                                                                <div class="form-group">
                                                                    <label>Bundle Title</label>
                                                                    <input type="text" class="form-control" name="bundle_title_<?php echo e($bundle_info->language_id); ?>" value="<?php echo e($bundle_info->bundle_title); ?>" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Bundle TOS</label>
                                                                    <textarea class="form-control" name="bundle_tos_<?php echo e($bundle_info->language_id); ?>"><?php echo e($bundle_info->bundle_tos); ?></textarea>
                                                                </div>
                                                            </div>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- /.box-body -->
                                            <div class="box-footer">
                                                <button type="submit" class="btn btn-primary"><?php echo e(trans('labels.submit')); ?></button>
                                                <a href="<?php echo e(URL::to('admin/bundles/display')); ?>" type="button" class="btn btn-default"><?php echo e(trans('labels.back')); ?></a>
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

    <script src="<?php echo asset('admin/plugins/jQuery/jQuery-2.2.0.min.js'); ?>"></script>
    <script type="text/javascript">
        $(function() {

            //for multiple languages
            <?php $__currentLoopData = $result['languages']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $languages): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace('editor<?php echo e($languages->languages_id); ?>');

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/app/current/resources/views/admin/bundles/edit.blade.php ENDPATH**/ ?>