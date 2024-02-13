

<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.arifurcontract'); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?> Forms <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?> Our Form Editors <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row justify-content-end">
        <!-- First button -->
        <div class="col-auto">
            <div class="text-end">
                <button type="button" class="btn btn-primary"  onclick="openModalNew()">Create New Contract</button>
            </div>
        </div>




<!-- Modal -->
<div class="modal" id="exampleModalNew" tabindex="-1" aria-labelledby="exampleModalLabelNew" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
             
        <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">CKEditor</h4>
                    <p class="card-title-desc">CKEditor is a powerful WYSIWYG text editor.</p>

                    <form id="contractFormmodal" method="post">
                        <div class="mb-3">
                            <label for="title" class="form-label">Contract Name</label>
                            <input type="text" class="form-control" id="titlemodal" name="titlemodal">
                        </div>
                        <textarea id="editormodal" name="editormodal"></textarea>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveDatamodal()">Save Project</button>
            </div>
        </div>
    </div>
</div>




        <!-- Second button -->
        <div class="col-auto">
            <div class="text-end"> <!-- Adjust alignment as needed -->
                <button type="button" class="btn btn-primary" onclick="saveData()">Save</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">CKEditor</h4>
                    <p class="card-title-desc">CKEditor is a powerful WYSIWYG text editor.</p>

                    <form id="contractForm" method="post">
                        <div class="mb-3">
                            <label for="title" class="form-label">Contract Name</label>
                            <input type="text" class="form-control" id="title" name="title">
                        </div>
                        <textarea id="editor" name="editor"></textarea>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <!-- CKEditor script -->
    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.0/classic/ckeditor.js"></script>

    <script>

        function openModalNew() {
                // Using Bootstrap's JavaScript to open the modal
                var myModal = new bootstrap.Modal(document.getElementById('exampleModalNew'));
                myModal.show();
            }
        

            let editor; // Global variable for main CKEditor instance
            let editormodal; // Global variable for modal CKEditor instance

            // Initialize main CKEditor instance
            ClassicEditor
                .create(document.querySelector('#editor'))
                .then(ed => {
                    editor = ed; // Assign the editor object to the global variable
                })
                .catch(error => {
                    console.error(error);
                });

            // Initialize modal CKEditor instance
            ClassicEditor
                .create(document.querySelector('#editormodal'))
                .then(ed => {
                    editormodal = ed; // Assign the editor object to the global variable
                })
                .catch(error => {
                    console.error(error);
                });

        function saveContent(title, content) {
            // Send title and content to Laravel backend using AJAX
            $.ajax({
                url: '/save',
                type: 'POST',
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                    title: title,
                    content: content
                },
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        // Function to save data when Save button is clicked
        function saveData() {
            const title = document.querySelector('#title').value; // Get title
            const content = editor.getData(); // Get content from CKEditor
            saveContent(title, content); // Call saveContent function to save data
        }

        function saveDatamodal() {
            const title = document.querySelector('#titlemodal').value; // Get title
            const content = editormodal.getData(); // Get content from CKEditor
            saveContent(title, content); // Call saveContent function to save data
        }

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Giacometti\Skote_Html_Laravel_v4.2.1\Laravel\Admin\resources\views/arifurcontract.blade.php ENDPATH**/ ?>