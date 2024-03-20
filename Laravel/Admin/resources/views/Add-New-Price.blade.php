
@extends('layouts.master')
@section('title')
    @lang('translation.arifurtable')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Projects
        @endslot
        @slot('title')
            Price List 
        @endslot
    @endcomponent
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!--  Arifur change  -->
     <div class="row">
            <div class="col-sm">
                <div class="search-box me-2 d-inline-block">
              <div class="position-relative">
                        <input type="text" class="form-control" autocomplete="off" id="searchInput" placeholder="Search...">
                        <i class="bx bx-search-alt search-icon"></i>
                    </div>  
                </div>
            </div>

             
    </div>

  <!--Price Name and  Currency  -->
  <div class="row mt-3">
    <div class="col-sm d-flex align-items-center">
        <label for="priceName" class="col-form-label me-3">Price Name :</label>
        <input type="text" id="priceName" name="priceName" class="form-control w-25" required>
    </div>
</div>

 

    <div class="row mt-3"> <!-- Added margin-top for spacing -->
        <div class="col-sm d-flex align-items-center">
            <label for="currency">Select currency : </label>
            <select id="currency" name="currency">
                <option value="EUR" {{ old('currency', 'EUR') === 'EUR' ? 'selected' : '' }}>Euro (EUR)</option>
                <option value="USD" {{ old('currency') === 'USD' ? 'selected' : '' }}>US Dollar (USD)</option>
                <option value="GBP" {{ old('currency') === 'GBP' ? 'selected' : '' }}>British Pound (GBP)</option>
                <option value="JPY" {{ old('currency') === 'JPY' ? 'selected' : '' }}>Japanese Yen (JPY)</option>
                <!-- Add more currency options as needed -->
            </select>
        </div>
    </div>

  <!-- fixed / dynamic  -->
 
    <style>
        .hidden {
            display: none;
        }
        input[type="range"] {
            width: 80%; /* Adjust the width as needed */
        }
    </style>
    <div class="row">

    </div>
 
  
    <div class="row mt-3">
    <div class="col-sm d-flex align-items-center">
    <label  for="selection">Select an option : </label>
    <select id="selection" name="selection">
        <option value="fixed">Fixed</option>
        <option value="dynamic">Dynamic</option>
    </select>
    </div>
    </div>

    <div class="row">

    </div>
    
    <div id="fixedInput" class="hidden">
        <label for="fixedValue">Enter a fixed value:</label>
        <input type="text" id="fixedValue" name="fixedValue">
    </div>

    <div id="dynamicInput" class="hidden">
        <label for="minRange">Min Range:</label>
        <input type="range" id="minRange" name="minRange" min="0" max="1000" oninput="updateMinValue(this.value)">
        <span id="minValue">0</span><br>

        <label for="maxRange">Max Range:</label>
        <input type="range" id="maxRange" name="maxRange" min="0" max="100000" oninput="updateMaxValue(this.value)">
        <span id="maxValue">100</span><br>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const selection = document.getElementById('selection');
        const fixedInput = document.getElementById('fixedInput');
        const dynamicInput = document.getElementById('dynamicInput');

        selection.addEventListener('change', function() {
            if (selection.value === 'fixed') {
                fixedInput.classList.remove('hidden');
                dynamicInput.classList.add('hidden');
            } else if (selection.value === 'dynamic') {
                dynamicInput.classList.remove('hidden');
                fixedInput.classList.add('hidden');
            }
        });

        // Trigger initial state based on the default value of the select element
        if (selection.value === 'fixed') {
            fixedInput.classList.remove('hidden');
            dynamicInput.classList.add('hidden');
        } else if (selection.value === 'dynamic') {
            dynamicInput.classList.remove('hidden');
            fixedInput.classList.add('hidden');
        }
    });

    function updateMinValue(value) {
        document.getElementById('minValue').innerText = value;
    }

    function updateMaxValue(value) {
        document.getElementById('maxValue').innerText = value;
    }
</script>

  <!-- VAT  -------------------------           -->
    <style>
        .VAThidden {
            display: none;
        }

        .checkbox-container {
           
        }

        .checkbox-container input[type="checkbox"] {
            margin-right: 30px;
        }
    </style>
 

    <label for="vatCheckbox">Enable VAT:</label>
    <input type="checkbox" id="vatCheckbox" name="vatCheckbox" onchange="toggleVATFields()">

    <div id="vatFields" class="VAThidden">
        <label for="vatPercentage">VAT Percentage:</label>
        <input type="number" id="vatPercentage" name="vatPercentage" min="0" max="100"> %

        <br><br>

        <div class="checkbox-container">
            <label for="includeOnPrice">Include on Price:</label>
            <input type="checkbox" id="includeOnPrice" name="includeOnPrice" onchange="toggleCheckbox(this)">
            
            <label for="external">Or     External:</label>
            <input type="checkbox" id="external" name="external" onchange="toggleCheckbox(this)">
        </div>
    </div>

    <script>
        function toggleVATFields() {
            var checkbox = document.getElementById('vatCheckbox');
            var vatFields = document.getElementById('vatFields');
            
            if (checkbox.checked) {
                vatFields.classList.remove('VAThidden');
            } else {
                vatFields.classList.add('VAThidden');
            }
        }

        function toggleCheckbox(checkbox) {
            var checkboxes = document.querySelectorAll('.checkbox-container input[type="checkbox"]');
            
            checkboxes.forEach(function(item) {
                if (item !== checkbox) {
                    item.checked = false;
                }
            });
        }
    </script>

<!-- single/ multiple payment  -->
 
<div class="row" >

</div>

<!-- multiple  -->

<style>
    .multiplepaymenthidden {
        display: none;
    }
</style>

<label for="priceType">Select Price Type:</label>
<select id="priceType" name="priceType" onchange="togglePriceOptions()">
    <option value="recurring">Recurring</option>
    <option value="oneTime">One Time</option>
</select>

<div id="oneTimeOptions" class="hidden">
    <label>Payment Options:</label><br>
    <input type="checkbox" id="singlePayment" name="paymentType" value="singlePayment" onchange="togglePaymentOption(this)">
    <label for="singlePayment">Single Payment</label><br>
    <input type="checkbox" id="multiplePayments" name="paymentType" value="multiplePayments" onchange="togglePaymentOption(this)">
    <label for="multiplePayments">Multiple Payments</label><br>
    <div id="multiplePaymentOptions" class="multiplepaymenthidden">
        <label for="minPaymentRange">Min Range:</label>
        <input type="range" id="minPaymentRange" name="minPaymentRange" min="0" max="1000" oninput="updateMinValuepayment(this.value)">
        <span id="minPaymentValue">0</span><br>
        <label for="maxPaymentRange">Max Range:</label>
        <input type="range" id="maxPaymentRange" name="maxPaymentRange" min="0" max="100000" oninput="updateMaxValuepayment(this.value)">
        <span id="maxPaymentValue">100</span><br>
        <!-- Additional input fields for min and max range -->
        <label for="minPayment">Example Text :</label>
        <input  type="text" id="minPayment" name="minPayment" value=" Sample text "><br>
        <!-- <label for="maxPayment">Max Payment:</label>
        <input type="text" id="maxPayment" name="maxPayment"><br> -->
    </div>
</div>


<script>
    function togglePriceOptions() {
        var priceType = document.getElementById('priceType').value;
        var oneTimeOptions = document.getElementById('oneTimeOptions');

        if (priceType === 'oneTime') {
            oneTimeOptions.classList.remove('hidden');
        } else {
            oneTimeOptions.classList.add('hidden');
        }
    }

    function togglePaymentOption(checkbox) {
        var checkboxes = document.querySelectorAll('#oneTimeOptions input[name="paymentType"]');
        var multiplePaymentOptions = document.getElementById('multiplePaymentOptions');

        if (checkbox.checked) {
            checkboxes.forEach(function(item) {
                if (item !== checkbox) {
                    item.checked = false;
                }
            });

            if (checkbox.value === 'multiplePayments') {
                multiplePaymentOptions.classList.remove('multiplepaymenthidden');
            } else {
                multiplePaymentOptions.classList.add('multiplepaymenthidden');
            }
        } else {
            multiplePaymentOptions.classList.add('multiplepaymenthidden');
        }
    }

    function updateMinValuepayment(value) {
        document.getElementById('minPaymentValue').innerText = value;
    }

    function updateMaxValuepayment(value) {
        document.getElementById('maxPaymentValue').innerText = value;
    }
</script>


<div class="row" >

</div>

<!-- Main save button -->
<button type="button"  id="saveButton" class="btn btn-success me-2 btn-lg" onclick="" >Save</button>



<script>

    //  Capture the click event of the save button
    document.getElementById('saveButton').addEventListener('click', function() {
        // Gather all necessary data
        var pricename = document.getElementById('priceName').value;
        var currency = document.getElementById('currency').value;
        
        var selectionValue = document.getElementById('selection').value;

        // Get the values from fixedInput and dynamicInput based on selection
        var fixedValue = '';
        var minRangeValue = '';
        var maxRangeValue = '';

        if (selectionValue === 'fixed') {
            fixedValue = document.getElementById('fixedValue').value;
        } else if (selectionValue === 'dynamic') {
            minRangeValue = document.getElementById('minRange').value;
            maxRangeValue = document.getElementById('maxRange').value;
        }

   
        var vatCheckbox = document.getElementById('vatCheckbox').checked;
        var vatPercentage = document.getElementById('vatPercentage').value;
        var includeOnPrice = document.getElementById('includeOnPrice').checked;
        var external = document.getElementById('external').checked;
        
        var priceType = document.getElementById('priceType').value;
        console.log('priceType :' , priceType);
 
       // var minPayment = document.getElementById('minPayment').value;
 
        var priceType = document.getElementById('priceType').value;

        if (priceType === 'oneTime'){
            
            var multiplePayments = document.getElementById('multiplePayments').checked;
            var singlePayment = document.getElementById('singlePayment').checked;
            if (multiplePayments ===true){
                var minPayment = document.getElementById('minPayment').value;
                var minPaymentRange = document.getElementById('minPaymentRange').value;
                var maxPaymentRange = document.getElementById('maxPaymentRange').value;  

            }
            else if (singlePayment === true){
           // do nothing 
                var minPayment =  '';
                var minPaymentRange = '';
                var maxPaymentRange = '';  
            }
        };
      
        var data = {
            pricename: pricename,
            currency: currency,
            fixedValue : fixedValue,
            minRangeValue : minRangeValue ,
            maxRangeValue : maxRangeValue ,
            vatCheckbox: vatCheckbox,
            vatPercentage: vatPercentage,
            includeOnPrice: includeOnPrice,
            external: external,
            priceType: priceType,
            singlePayment: singlePayment,
            multiplePayments : multiplePayments ,
            minPaymentRange: minPaymentRange,
            maxPaymentRange :maxPaymentRange,
            minPayment:minPayment,
            
        };


        // Send AJAX request
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

   

        $.ajax({
            url: '/save-price-list',
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                console.log('All response:', response);
                alert('Data saved successfully for the price List!');
                window.location.href = 'Price-List';
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Fill all the field while saving data.');
            }
        });


        // axios.post('/save-price-list', data)
        //     .then(function(response) {
        //         // Handle success response
        //         console.log(response.data);
        //         alert('Data saved successfully!');
        //     })
        //     .catch(function(error) {
        //         // Handle error response
        //         console.error(error);
        //         alert('Error occurred while saving data.');
        //     });


    });   
</script>

@endsection