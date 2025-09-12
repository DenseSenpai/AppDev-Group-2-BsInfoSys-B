<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Student
            </h2>

            <!-- Back Button -->
            <a href="<?php echo e(route('students.index')); ?>"
               class="inline-block bg-gray-500 hover:bg-gray-600 text-white font-bold px-6 py-2 rounded shadow">
               ← Back to Students
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <!-- Show Validation Errors -->
            <?php if($errors->any()): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc pl-6">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Edit Student Form -->
            <form action="<?php echo e(route('students.update', $student->id)); ?>" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="mb-4">
                    <label class="block text-gray-700">Student No:</label>
                    <input type="text" name="studentno" value="<?php echo e(old('studentno', $student->studentno)); ?>"
                           class="w-full border rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:ring-blue-300">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">First Name:</label>
                    <input type="text" name="firstname" value="<?php echo e(old('firstname', $student->firstname)); ?>"
                           class="w-full border rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:ring-blue-300">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Middle Name:</label>
                    <input type="text" name="middlename" value="<?php echo e(old('middlename', $student->middlename)); ?>"
                           class="w-full border rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:ring-blue-300">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Last Name:</label>
                    <input type="text" name="lastname" value="<?php echo e(old('lastname', $student->lastname)); ?>"
                           class="w-full border rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:ring-blue-300">
                </div>

                <!-- Update Button -->
                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white font-bold px-6 py-2 rounded shadow">
                        💾 Update Student
                    </button>
                </div>
            </form>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\SCS\resources\views/students/edit.blade.php ENDPATH**/ ?>