
<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.arifurtable'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Projects
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
           Edit Contract List 
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




    <div class="card">
            <div class="card-body">
                <form id="editpagenew">
                    <input type="hidden" id="contract-id" value="<?php echo e($contract->id); ?>">
                    
                    <div class="d-flex align-items-center mb-3">
                        <label for="title" class="form-label me-2" style="width: 120px;">Contract Name</label>
                        <input type="text" class="form-control w-75" id="title" name="contract_name" value="<?php echo e($contract->contract_name); ?>">
                        
                        <!-- Product Button -->
                        <button type="button" class="btn btn-primary me-2 btn-lg">Product</button>
                        
                        <!-- Variable Button -->
                        <button type="button" class="btn btn-primary me-2 btn-lg" onclick="openModalNew()">Variable</button>
                        
                        <!-- Save Button -->
                        <button type="button" class="btn btn-success me-2 btn-lg" onclick="saveData()">Update</button>
                    </div>

                    <textarea id="editor" name="editor" style="width: 100%; max-width: 500px;"><?php echo e($contract->editor_content); ?></textarea>
                    <style>
                        

                        .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
                            border-color: var(--ck-color-base-border);
                            height: 400px !important;
                        
                        }
                        .ck.ck-editor__editable_inline>:last-child {
                            margin-bottom: var(--ck-spacing-large);
                            height: 400px;
                        }

                        </style>
               
                </form>
            </div>
        </div>



<!-- variable Modal -->
<!-- product list Modal -->
<div class="modal" id="exampleModalNew" tabindex="-1" aria-labelledby="exampleModalLabelNew" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelNew">Variable List</h5>
                <div class="col-sm">
                    <div class="search-box me-2 d-inline-block">
                        <div class="position-relative">
                            <input type="text" class="form-control" autocomplete="off" id="searchInput" placeholder="Search...">
                            <i class="bx bx-search-alt search-icon"></i>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="productFormNew" action="/edit-contract-list" method="POST" >
                    <!-- for table -->
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <!-- Wrap the table inside a div with fixed height and auto scroll -->
                    <div style="max-height: 400px; overflow-y: auto;">
                        <table id="ContractList" action="/edit-contract-list" method="POST" class="table">
                            <thead>
                                <tr>
                                    <th>VariableID</th>
                                    <th>Var Name</th>
                                    <th>Var Type</th>
                                    <th>Description</th>
                                    <th>CreatedDate</th>
                                    <th>UpdatedDate</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $variables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($contract->VariableID); ?></td>
                                        <td><?php echo e($contract->VariableName); ?></td>
                                        <td><?php echo e($contract->VariableType); ?></td>
                                        <td><?php echo e($contract->Description); ?></td>
                                        <td><?php echo e($contract->created_at); ?></td>
                                        <td><?php echo e($contract->updated_at); ?></td>
                                        <td>
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input add-checkbox"
                                                    onchange="checkCheckbox(this, '<?php echo e($contract->VariableName); ?>')">
                                            </label>
                                            <button type="button" class="btn btn-primary add-button"
                                                data-bs-dismiss="modal" onclick="insertVariable('<?php echo e($contract->VariableName); ?>')" disabled>Add</button>
                                        </td>


                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary" onclick="">Save Product</button> -->
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>
       
        //  main working code 
        let editor; // Global variable for main CKEditor instance        
        
        ClassicEditor
        .create(document.querySelector('#editor'))
        .then(createdEditor => {
            // Assign the created editor to the global variable
            editor = createdEditor;

            // Define a function to insert text into CKEditor 5
            window.insertVariable = function(variableName) {
                // Insert variableName at the current cursor position
                const currentPosition = editor.model.document.selection.getLastPosition();
                if (currentPosition) {
                    editor.model.change(writer => {
                        writer.insertText("%"+variableName+"%", currentPosition);
                    });
                }
            };
        })
        .catch(error => {
            console.error(error);
        });

                

        function saveData() {
        // Check if CKEditor is initialized
        if (!editor) {
            console.error('CKEditor is not initialized.');
            return;
        }

        // Get the contract ID from the hidden input field
        const contractId = document.querySelector('#contract-id').value;

        // Get the contract name from the input field
        const contractName = document.querySelector('#title').value;

        // Check if the contract name is empty
        if (!contractName.trim()) {
            console.error('Contract name cannot be empty.');
            return;
        }

        // Get the editor content from CKEditor
        const editorContent = editor.getData();

        // Prepare the form data
        const formData = {
            _token: "<?php echo e(csrf_token()); ?>",
            id: contractId,
            contract_name: contractName,
            editor_content: editorContent
        };

        // Call the saveContent function to save the data
        saveContent(formData);
    }


    function saveContent(formData) {
    $.ajax({
        url: '/edit-contract-list/update', // Change the URL to the update route
        type: 'POST',
        data: formData,
        success: function(response) {
            console.log(response);
            // Optionally, you can redirect or show a success message here
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            // Optionally, you can handle errors here
        }
    });
    }


        

        //Function to insert a variable into CKEditor
        function insertVariable(variableName) {
            // Get the current content of the editor
            const currentContent = editor.getData();
            // Append the variable to the content with % signs
            const newContent = currentContent + `%${variableName}%`;
            // Set the updated content back to the editor
            editor.setData(newContent);
        }
 
        function countOccurrences(str, searchValue) {
        var regex = new RegExp(searchValue, 'g');
        var matches = str.match(regex);
        return matches ? matches.length : 0;
        }

        // Function to delete a substring from a string
        function deleteSubstring(str, searchValue) {
            var regex = new RegExp(searchValue, 'g');
            return str.replace(regex, '');
        }

        // Function to handle checkbox change event
        // Function to handle checkbox change event
         // Function to handle checkbox change event
        function checkCheckbox(checkbox, variableName) {
            var $row = $(checkbox).closest('tr'); // Find the parent row

            if (checkbox.checked) {
                $row.find('.add-button').prop('disabled', false); // Enable button if checkbox is checked
            } else {
                var editorData = editor.getData();
                var count = countOccurrences(editorData, variableName);

                if (count > 0) {
                    Swal.fire({
                        title: 'Variable Found!',
                        text: 'The variable ' + variableName + ' appears ' + count + ' times in the editor content. Do you want to delete it?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it',
                        cancelButtonText: 'No, cancel',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Perform delete operation
                            var latestvar = "%" + variableName + "%"
                            editorData = deleteSubstring(editorData, latestvar);
                            editor.setData(editorData);
                        } else {
                            // If user cancels deletion, recheck the checkbox
                            checkbox.checked = true;
                            $row.find('.add-button').prop('disabled', false); // Enable button as checkbox is checked
                        }
                    });
                } else {
                    // If no occurrences found, enable button directly
                    $row.find('.add-button').prop('disabled', false);
                }
            }
        }


            
            $(document).ready(function() {
                // Delegate the change event handling to the tbody element
                $('tbody').on('change', '.add-checkbox', function() {
                    // Find the parent row of the checkbox
                    var $row = $(this).closest('tr');
                    // Find the add button within the same row and enable/disable it based on the checkbox state
                    $row.find('.add-button').prop('disabled', !$(this).prop('checked'));
                });
            });

            function openModalNew() {
                // Using Bootstrap's JavaScript to open the product list modal
                var myModal = new bootstrap.Modal(document.getElementById('exampleModalNew'));
                myModal.show();
            }
            
            $('#exampleModalNew').modal('hide');

 
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Giacometti\Skote_Html_Laravel_v4.2.1\Laravel\Admin\resources\views/Edit-ContractList.blade.php ENDPATH**/ ?>