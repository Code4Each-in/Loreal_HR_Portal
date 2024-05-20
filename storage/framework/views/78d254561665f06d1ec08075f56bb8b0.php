
<?php echo $__env->make('layout.includes.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



<body>

  <?php echo $__env->make('layout.sections.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <?php echo $__env->make('layout.sections.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



  <main id="main" class="main">
                    <div class="pagetitle">
                        <h1><?php echo $__env->yieldContent('sub-title'); ?></h1>
                    </div><!-- End Page Title -->  
                <div id="app">
                        <div class="row">                             
                            <main class="col">
                                <!--begin::Main-->
                                <?php echo $__env->yieldContent('content'); ?>
                                <!--end::Main-->
                            </main>
                        </div>
                </div>
                </main>

  <?php echo $__env->make('layout.sections.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <?php echo $__env->make('layout.includes.js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


</body>

</html><?php /**PATH D:\LOreal_HR_Portal\resources\views/layout/app.blade.php ENDPATH**/ ?>