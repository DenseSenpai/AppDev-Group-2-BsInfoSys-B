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
                Students
            </h2>

            <!-- Big, clear Add Student button -->
            <a href="<?php echo e(route('students.create')); ?>"
               class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2 rounded shadow">
               ➕ Add Student
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Success Message -->
            <?php if(session('success')): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <!-- Students Table -->
            <div class="overflow-x-auto bg-white shadow rounded-lg">
                <table class="min-w-full border border-gray-300">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border px-4 py-2 text-left">ID</th>
                            <th class="border px-4 py-2 text-left">Student No</th>
                            <th class="border px-4 py-2 text-left">First Name</th>
                            <th class="border px-4 py-2 text-left">Middle Name</th>
                            <th class="border px-4 py-2 text-left">Last Name</th>
                            <th class="border px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2"><?php echo e($student->id); ?></td>
                                <td class="border px-4 py-2"><?php echo e($student->studentno); ?></td>
                                <td class="border px-4 py-2"><?php echo e($student->firstname); ?></td>
                                <td class="border px-4 py-2"><?php echo e($student->middlename); ?></td>
                                <td class="border px-4 py-2"><?php echo e($student->lastname); ?></td>
                                <td class="border px-4 py-2">
                                    <a href="<?php echo e(route('students.edit', $student->id)); ?>"
                                       class="text-blue-600 hover:underline mr-2">Edit</a>

                                    <form action="<?php echo e(route('students.destroy', $student->id)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit"
                                                class="text-red-600 hover:underline"
                                                onclick="return confirm('Are you sure you want to delete this student?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="border px-4 py-2 text-center text-gray-500">
                                    No students found.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
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
<?php /**PATH C:\laragon\www\SCS\resources\views/students/index.blade.php ENDPATH**/ ?>