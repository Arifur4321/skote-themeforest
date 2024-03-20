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
    <!--code starts here --> 
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> 


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
        <input type="text" id="priceName" name="priceName" class="form-control w-25" value="{{$priceList->pricename }}">
    </div>
</div>

<!-- Added margin-top for spacing -->
<div class="row mt-3"> 
    <div class="col-sm d-flex align-items-center">
        <label for="currency">Select currency : </label>
        <select id="currency" name="currency">
            <option value="EUR" {{ $priceList->currency === 'EUR' ? 'selected' : '' }}>Euro (EUR)</option>
            <option value="USD" {{ $priceList->currency === 'USD' ? 'selected' : '' }}>US Dollar (USD)</option>
            <option value="GBP" {{ $priceList->currency === 'GBP' ? 'selected' : '' }}>British Pound (GBP)</option>
            <option value="JPY" {{ $priceList->currency === 'JPY' ? 'selected' : '' }}>Japanese Yen (JPY)</option>
            <!-- Add more currency options as needed -->
        </select>
    </div>
</div>

<style>
    .hidden {
        display: none;
    }
    input[type="range"] {
        width: 80%; /* Adjust the width as needed */
    }
</style>

<div class="row mt-3">
    <div class="col-sm d-flex align-items-center">
        <label for="selection">Select an option : </label>
        <select id="selection" name="selection">
            <option value="fixed">Fixed</option>
            <option value="dynamic">Dynamic</option>
        </select>
    </div>
</div>

<div class="row mt-3">
    <div class="col-sm">
        <div id="fixedInput" class="{{ $priceList->selection === 'fixed' ? '' : 'hidden' }}">
            <label for="fixedValue">Enter a fixed value:</label>
            <input type="text" id="fixedValue" name="fixedValue" value="{{ $priceList->fixedvalue }}">
        </div>

        <div id="dynamicInput" class="{{ $priceList->selection === 'dynamic' ? '' : 'hidden' }}">
            <label for="minRange">Min Range:</label>
            <input type="range" id="minRange" name="minRange" min="0" max="1000" value="{{ $priceList->dynamicminRange }}" oninput="updateMinValue(this.value)">
            <span id="minValue">{{ $priceList->dynamicminRange }}</span><br>

            <label for="maxRange">Max Range:</label>
            <input type="range" id="maxRange" name="maxRange" min="0" max="100000" value="{{ $priceList->dynamicmaxRange }}" oninput="updateMaxValue(this.value)">
            <span id="maxValue">{{ $priceList->dynamicmaxRange }}</span><br>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selection = document.getElementById('selection');
    const fixedInput = document.getElementById('fixedInput');
    const dynamicInput = document.getElementById('dynamicInput');

    // Get the value of the selection from the database
    const databaseValue = "{{ $priceList->fixedvalue }}";

    // Set the initial state based on the database value
    if (databaseValue > 0) {
        selection.value = 'fixed';
        fixedInput.classList.remove('hidden');
        dynamicInput.classList.add('hidden');
    } else   {
        selection.value = 'dynamic';
        dynamicInput.classList.remove('hidden');
        fixedInput.classList.add('hidden');
    }

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

 <!-- VAT Section -->
<label for="vatCheckbox">Enable VAT:</label>
<input type="checkbox" id="vatCheckbox" name="vatCheckbox" onchange="toggleVATFields()" {{ $priceList->enableVat === 'true' ? 'checked' : '' }}>

<div id="vatFields" class="{{ $priceList->enableVat === 'true' ? '' : 'VAThidden' }}">
    <label for="vatPercentage">VAT Percentage:</label>
    <input type="number" id="vatPercentage" name="vatPercentage" min="0" max="100" value="{{ $priceList->vatPercentage }}" {{ $priceList->enableVat === 'true' ? '' : 'disabled' }}> %

    <br><br>
</div>
<div class="checkbox-container">
    <label for="includeOnPrice">Include on Price:</label>
    <input type="checkbox" id="includeOnPrice" name="includeOnPrice" {{ $priceList->price === 'true' ? 'checked' : '' }} {{ $priceList->enableVat === 'true' ? '' : 'disabled' }} onchange="handleExclusiveSelection(this)">
    
    <label for="external">Or External:</label>
    <input type="checkbox" id="external" name="external" {{ $priceList->external === 'true' ? 'checked' : '' }} {{ $priceList->enableVat === 'true' ? '' : 'disabled' }} onchange="handleExclusiveSelection(this)">
</div>

<script>
function toggleVATFields() {
    var vatCheckbox = document.getElementById('vatCheckbox');
    var vatFields = document.getElementById('vatFields');
    var vatPercentage = document.getElementById('vatPercentage');
    var includeOnPrice = document.getElementById('includeOnPrice');
    var external = document.getElementById('external');

    if (vatCheckbox.checked) {
        vatFields.classList.remove('VAThidden');
        vatPercentage.disabled = false;
        includeOnPrice.disabled = false;
        external.disabled = false;
    } else {
        vatFields.classList.add('VAThidden');
        vatPercentage.disabled = true;
        includeOnPrice.disabled = true;
        external.disabled = true;
    }
}

function handleExclusiveSelection(checkbox) {
    if (checkbox.checked) {
        if (checkbox.id === 'includeOnPrice') {
            document.getElementById('external').checked = false;
        } else if (checkbox.id === 'external') {
            document.getElementById('includeOnPrice').checked = false;
        }
    }
}
</script>

<!-- multiple payments -->

<style>
    .multiplepaymenthidden {
        display: none;
    }
</style>

<label for="priceType">Select Price Type:</label>
<select id="priceType" name="priceType" onchange="togglePriceOptions()">
    <option value="recurring" {{ $priceList->selectPriceType === 'recurring' ? 'selected' : '' }}>Recurring</option>
    <option value="oneTime" {{ $priceList->selectPriceType === 'oneTime' ? 'selected' : '' }}>One Time</option>
</select>

<div id="oneTimeOptions" class="{{ $priceList->selectPriceType === 'oneTime' ? '' : 'hidden' }}">
    <label>Payment Options:</label><br>
    <input type="checkbox" id="singlePayment" name="paymentType" value="singlePayment" {{ $priceList->singlePayment ? 'checked' : '' }} onchange="togglePaymentOption(this); ensureSinglePaymentOption(this)">

    <label for="singlePayment">Single Payment</label><br>
    
    <input type="checkbox" id="multiplePayments" name="paymentType" value="multiplePayments" {{ $priceList->multiplePayments ? 'checked' : '' }} onchange="togglePaymentOption(this); ensureSinglePaymentOption(this)">

    <label for="multiplePayments">Multiple Payments</label><br>
    <div id="multiplePaymentOptions" class="{{ $priceList->multiplePayments ? '' : 'multiplepaymenthidden' }}">
        <label for="minPaymentRange">Min Range:</label>
        <input type="range" id="minPaymentRange" name="minPaymentRange" min="0" max="1000" value="{{ $priceList->paymentMinRange }}" oninput="updateMinValuepayment(this.value)">
        <span id="minPaymentValue">{{ $priceList->paymentMinRange }}</span><br>
        <label for="maxPaymentRange">Max Range:</label>
        <input type="range" id="maxPaymentRange" name="maxPaymentRange" min="0" max="100000" value="{{ $priceList->paymentMaxRange }}" oninput="updateMaxValuepayment(this.value)">
        <span id="maxPaymentValue">{{ $priceList->paymentMaxRange }}</span><br>
        <!-- Additional input fields for min and max range -->
        <label for="minPayment">Example Text:</label>
        <input type="text" id="minPayment" name="minPayment" value="{{ $priceList->paymentExampleText }}"><br>
        <!-- <label for="maxPayment">Max Payment:</label>
        <input type="text" id="maxPayment" name="maxPayment"><br> -->
    </div>
</div>

    <script>
        // Initial setup to reflect the data from the database
        document.addEventListener('DOMContentLoaded', function() {
            var singlePaymentCheckbox = document.getElementById('singlePayment');
            var multiplePaymentsCheckbox = document.getElementById('multiplePayments');
            
            // Reflect data for Single Payment checkbox
            if ("{{ $priceList->singlePayment }}" === "true") {
                singlePaymentCheckbox.checked = true;

                var multiplePaymentOptions = document.getElementById('multiplePaymentOptions');
                multiplePaymentOptions.classList.add('multiplepaymenthidden');
            
            } else {
                singlePaymentCheckbox.checked = false;
            }

            // Reflecttion of data for Multiple Payments checkbox
            if ("{{ $priceList->multiplePayments }}" === "true") {
                multiplePaymentsCheckbox.checked = true;
            } else {
                multiplePaymentsCheckbox.checked = false;
                
            }
        });

       function togglePriceOptions() {
        var priceType = document.getElementById('priceType').value;
        var oneTimeOptions = document.getElementById('oneTimeOptions');

        if (priceType === 'oneTime') {
            oneTimeOptions.classList.remove('hidden');
        } else {
            oneTimeOptions.classList.add('hidden');
        }
    }
    // Function to toggle the visibility of payment options
    function togglePaymentOption(checkbox) {
        var singlePaymentCheckbox = document.getElementById('singlePayment');
        var multiplePaymentsCheckbox = document.getElementById('multiplePayments');
        var multiplePaymentOptions = document.getElementById('multiplePaymentOptions');

        if (checkbox.checked) {
            if (checkbox.id === 'singlePayment') {
                singlePaymentCheckbox.checked = true;
                multiplePaymentsCheckbox.checked = false; // Uncheck Multiple Payments
                multiplePaymentOptions.classList.add('multiplepaymenthidden');
            } else if (checkbox.id === 'multiplePayments') {
                multiplePaymentsCheckbox.checked = true;
                singlePaymentCheckbox.checked = false; // Uncheck Single Payment
                multiplePaymentOptions.classList.remove('multiplepaymenthidden');
            }
        } else {
            multiplePaymentOptions.classList.add('multiplepaymenthidden');
        }
    }

    // Function to ensure only one payment option is checked at a time
    function ensureSinglePaymentOption(checkbox) {
        var singlePaymentCheckbox = document.getElementById('singlePayment');
        var multiplePaymentsCheckbox = document.getElementById('multiplePayments');

        if (checkbox.checked && checkbox.id === 'singlePayment') {
            singlePaymentCheckbox.checked = true;
            multiplePaymentsCheckbox.checked = false;
        } else if (checkbox.checked && checkbox.id === 'multiplePayments') {
            singlePaymentCheckbox.checked = false;
            multiplePaymentsCheckbox.checked = true;
        }
    }

    // Function to update the min range value
    function updateMinValuepayment(value) {
        document.getElementById('minPaymentValue').innerText = value;
    }

    // Function to update the max range value
    function updateMaxValuepayment(value) {
        document.getElementById('maxPaymentValue').innerText = value;
    }
    </script>

<!--    ------------------------------------------------   -->

<div class="row">

</div>

<!-- Main update button to insert data in database -->
<button type="button"  id="saveButton" class="btn btn-success me-2 btn-lg" onclick="saveChanges()" >Update</button>

<script>
    // Function to save the edited data
    function saveChanges() {
    // Gather data from form all fields 
    var priceName = document.getElementById('priceName').value;
    var currency = document.getElementById('currency').value;

    var selectionValue = document.getElementById('selection').value;

    // to Get the values for the fixedInput and dynamicInput based on selection
    var fixedValue = '';
    var minRange = '';
    var maxRange = '';
    if (selectionValue === 'fixed') {
        fixedValue = document.getElementById('fixedValue').value;
    } else if (selectionValue === 'dynamic') {
        minRange = document.getElementById('minRange').value;
        maxRange = document.getElementById('maxRange').value;
    }
 
    var enableVat = document.getElementById('vatCheckbox').checked;
    var vatPercentage = document.getElementById('vatPercentage').value;
    var includeOnPrice = document.getElementById('includeOnPrice').checked;

    console.log('includeOnPrice :' , includeOnPrice);
    
    var external = document.getElementById('external').checked;

    var priceType = document.getElementById('priceType').value;
    if (priceType === 'oneTime'){
        var multiplePayments = document.getElementById('multiplePayments').checked;
        if (multiplePayments === true){
            var minPaymentRange = document.getElementById('minPaymentRange').value;
            var maxPaymentRange = document.getElementById('maxPaymentRange').value;
            var paymentExampleText = document.getElementById('minPayment').value; 
        }

        var singlePayment = document.getElementById('singlePayment').checked;
        if (singlePayment === true){
          // do nothing 
          var minPaymentRange = '';
          var maxPaymentRange = '';
          var paymentExampleText = '';
        }
    }

    var data = {
        pricename: priceName,
        currency: currency,
        fixedvalue: fixedValue,
        dynamicminRange: minRange,
        dynamicmaxRange: maxRange,
        enableVat: enableVat,
        vatPercentage: vatPercentage,
        includeOnPrice: includeOnPrice,
        external: external,
        priceType: priceType,
        singlePayment: singlePayment,
        multiplePayments: multiplePayments,
        paymentMinRange: minPaymentRange,
        paymentMaxRange: maxPaymentRange,
        paymentExampleText: paymentExampleText
    };

    // Send AJAX request to update the price
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: '/update-price/' + {{ $priceList->id }},
        type: 'POST',
        data: data,
        headers: {
                'X-CSRF-TOKEN': csrfToken
        },
        success: function(response) {
            console.log(response);
            alert('Price updated successfully!');
            // Redirect to a new page or perform any other action upon success
            window.location.href = '/Price-List';
        },
        error: function(xhr, status, error) {
            console.error(error);
            alert('Fill all the Form while updating price.');
        }
    });
}

</script>

@endsection