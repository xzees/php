<style>
  :root {
    --bg-color: <?= $data['base_color'] ?>;
  }

  .cde a {
    background-color: transparent;
  }

  .cde a:active,
  .cde a:hover {
    outline: 0;
  }

  .cde b {
    font-weight: 700;
  }

  .cde img {
    border: 0;
  }

  .cde svg:not(:root) {
    overflow: hidden;
  }

  .cde button,
  input,
  select {
    margin: 0;
    font: inherit;
    color: inherit;
  }

  .cde button {
    overflow: visible;
  }

  .cde button,
  .cde select {
    text-transform: none;
  }

  .cde button {
    -webkit-appearance: button;
    cursor: pointer;
  }

  .cde button[disabled] {
    cursor: default;
  }

  .cde button::-moz-focus-inner,
  input::-moz-focus-inner {
    padding: 0;
    border: 0;
  }

  .cde input {
    line-height: normal;
  }

  .cde input[type=checkbox],
  input[type=radio] {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    padding: 0;
  }



  .cde * {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
  }

  .cde :after,
  :before {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
  }

  .cde button,
  input,
  select {
    font-family: inherit;
    font-size: inherit;
    line-height: inherit;
  }

  .cde a {
    color: #337ab7;
    text-decoration: none;
  }

  .cde a:focus,
  a:hover {
    color: #23527c;
    text-decoration: underline;
  }

  .cde a:focus {
    outline: thin dotted;
    outline: 5px auto -webkit-focus-ring-color;
    outline-offset: -2px;
  }

  .cde img {
    vertical-align: middle;
  }

  .cde .col-lg-12,
  .col-lg-4,
  .col-md-12,
  .col-md-6,
  .col-sm-12,
  .col-sm-4,
  .col-sm-6,
  .col-xs-12 {
    position: relative;
    min-height: 1px;
    padding-right: 15px;
    padding-left: 15px;
  }

  .cde .col-xs-12 {
    float: left;
  }

  .cde .col-xs-12 {
    width: 100%;
  }

  @media (min-width:768px) {

    .cde .col-sm-12,
    .col-sm-4,
    .col-sm-6 {
      float: left;
    }

    .cde .col-sm-12 {
      width: 100%;
    }

    .cde .col-sm-6 {
      width: 50%;
    }

    .cde .col-sm-4 {
      width: 33.33333333%;
    }
  }

  @media (min-width:992px) {

    .cde .col-md-12,
    .cde .col-md-6 {
      float: left;
    }

    .cde .col-md-12 {
      width: 100%;
    }

    .cde .col-md-6 {
      width: 50%;
    }
  }

  @media (min-width:1200px) {

    .cde .col-lg-12,
    .cde .col-lg-4 {
      float: left;
    }

    .cde .col-lg-12 {
      width: 100%;
    }

    .cde .col-lg-4 {
      width: 33.33333333%;
    }
  }

  .cde label {
    display: inline-block;
    max-width: 100%;
    font-weight: 700;
  }

  .cde input[type=checkbox],
  input[type=radio] {
    margin: 4px 0 0;
    margin-top: 1px\9;
    line-height: normal;
  }

  .cde input[type=checkbox]:focus,
  input[type=radio]:focus {
    outline: thin dotted;
    outline: 5px auto -webkit-focus-ring-color;
    outline-offset: -2px;
  }

  .cde .form-group {
    line-height: 24px;
  }

  .cde .checkbox {
    position: relative;
    display: block;
    margin-bottom: 10px;
  }

  .cde .form-horizontal .checkbox {
    padding-top: 7px;
    margin-top: 0;
    margin-bottom: 0;
  }

  .cde .form-horizontal .checkbox {
    min-height: 27px;
  }

  .cde .form-horizontal .form-group {
    margin-right: -15px;
    margin-left: -15px;
  }

  .cde .btn {
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
  }

  .cde .btn:active:focus,
  .cde .btn:focus {
    outline: thin dotted;
    outline: 5px auto -webkit-focus-ring-color;
    outline-offset: -2px;
  }

  .cde .btn:focus,
  .cde .btn:hover {
    color: #fff;
    text-decoration: none;
  }

  .cde .btn:active {
    background-image: none;
    outline: 0;
    -webkit-box-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
    box-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
  }

  .cde .btn[disabled] {
    cursor: not-allowed;
    filter: alpha(opacity=65);
    -webkit-box-shadow: none;
    box-shadow: none;
    opacity: .65;
  }

  .cde .form-horizontal .form-group:after,
  .cde .form-horizontal .form-group:before {
    display: table;
    content: " ";
  }

  .cde .form-horizontal .form-group:after {
    clear: both;
  }

  .cde .invisible {
    visibility: hidden;
  }

  .cde * {
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    margin: 0;
    -webkit-tap-highlight-color: transparent;
    zoom: 1;
  }

  .cde img {
    border: 0;
  }

  .cde a {
    text-decoration: none;
    color: inherit;
  }

  .cde a:hover,
  .cde a:focus {
    color: linear-gradient(white, var(--bg-color));
    text-decoration: none;
  }

  .cde a:focus {
    outline: none;
  }

  .cde .full-width {
    width: 100% !important;
  }

  .cde input.input-text,
  .cde select {
    background: #f5f5f5;
    border: none;
    line-height: normal;
  }

  .cde input.input-text {
    padding-left: 15px;
    padding-right: 15px;
    height: 34px;
    border: 1px solid #ccc;
    font-size: 1.2em;
  }

  .cde select {
    height: 34px;
    padding: 8px 0 8px 8px;
  }

  .cde select option {
    padding: 2px 10px;
  }

  .cde .checkbox {
    position: relative;
    margin-top: 0;
    line-height: 20px;
  }

  .cde .checkbox:before {
    display: block;
    content: "";
    position: absolute;
    left: 0;
    top: 3px;
    width: 14px;
    height: 14px;
    border: 1px solid #d1d1d1;
    z-index: 0;
    font-family: "soap-icons";
    line-height: 12px;
    text-align: center;
  }

  .cde form label {
    text-transform: uppercase;
    display: block;
    margin-bottom: 5px;
    font-weight: normal;
    font-size: 0.9167em;
  }

  .cde form .form-group {
    margin-bottom: 15px;
  }

  .cde button,
  .cde label {
    letter-spacing: 0.04em;
  }

  .cde button {
    border: none;
    color: #fff;
    cursor: pointer;
    padding: 0 15px;
    white-space: nowrap;
  }

  .cde button {
    font-size: 0.9167em;
    font-weight: bold;
    background: #98ce44;
    height: 34px;
    line-height: 34px;
  }

  .cde button:hover {
    background: #7fb231;
  }

  .cde img {
    max-width: 100%;
    height: auto;
  }

  .cde a:hover,
  .cde a:focus {
    color: #ff7700;
    text-decoration: none;
  }

  .cde button,
  .cde label {
    letter-spacing: 0;
  }

  .cde button {
    background-color: var(--bg-color);
    font-size: 1.2em;
    min-width: 170px;
  }

  .cde button:hover {
    background: var(--bg-color);
    filter: brightness(1.2);
  }

  .cde button {
    font-family: fontttc-bold;
    font-weight: normal;
  }

  .cde form label {
    font-size: 1.2em;
  }

  .cde label.required::after {
    content: ' * ';
    color: #f00;
  }

  .cde .insurance-payment {
    position: relative;
    padding: 30px 0;
    height: 800px;
    transition: 1s ease;
    transition-property: height, opacity;
  }

  .cde .input-wrap {
    position: relative;
    min-height: 40px;
  }

  .cde .input-wrap .input-text {
    background: #fff;
    height: 40px;
    border: 1px solid rgba(0, 0, 0, 0.1);
    margin: 0;
    border-radius: 5px;
    transition: 1s ease;
    transition-property: border, box-shadow, color;
  }

  .cde .input-wrap .input-text::placeholder {
    transition: color 1s ease;
  }

  .cde .input-wrap:after {
    display: block;
    font-family: fontawesome;
    font-size: 20px;
    color: #cccccc;
    background: 0;
    position: absolute;
    left: 5px;
    top: 12px;
    bottom: 0;
    width: 30px;
    height: 100%;
    line-height: 34px;
    transition: color 1s ease;
  }

  .cde .input-wrap select {
    padding: 0 0 0 10px;
    font-size: 1.2em;
  }

  @media screen and (min-color-index:0) and(-webkit-min-device-pixel-ratio:0) {
    @media {
      .cde .input-wrap select {
        text-indent: 27px;
        font-size: 1.2em;
      }
    }
  }

  @media not all and (min-resolution:.001dpcm) {
    @media {
      .cde .input-wrap select {
        text-indent: 27px;
        font-size: 1.2em;
      }
    }
  }

  .cde .label-filter-star {
    display: block;
    user-select: none;
    cursor: pointer;
    margin-bottom: 10px;
    padding: 0;
  }

  .cde .label-filter-star input:checked+.checkbox {
    border-color: var(--bg-color);
  }

  .cde .label-filter-star input:checked+.checkbox svg path {
    fill: var(--bg-color);
  }

  .cde .label-filter-star input:checked+.checkbox svg polyline {
    stroke-dashoffset: 0;
  }

  .cde .label-filter-star:hover .checkbox svg path {
    stroke-dashoffset: 0;
  }

  .cde .label-filter-star .checkbox {
    position: relative;
    top: 2px;
    float: left;
    margin-bottom: 0;
    margin-right: 8px;
    width: 18px;
    height: 18px;
    border: 2px solid #C8CCD4;
    border-radius: 3px;
  }

  .cde .label-filter-star .checkbox svg {
    position: absolute;
    top: -2px;
    left: -2px;
  }

  .cde .label-filter-star .checkbox svg path {
    fill: none;
    stroke: var(--bg-color);
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
    stroke-dasharray: 71px;
    stroke-dashoffset: 71px;
    transition: all 0.6s ease;
  }

  .cde .label-filter-star .checkbox svg polyline {
    fill: none;
    stroke: #fff;
    stroke-width: 3;
    stroke-linecap: round;
    stroke-linejoin: round;
    stroke-dasharray: 18px;
    stroke-dashoffset: 18px;
    transition: all 0.3s ease;
  }

  .cde .invisible {
    position: absolute;
    z-index: -1;
    width: 0;
    height: 0;
    opacity: 0;
  }

  .cde label.label-filter-star .checkbox:before {
    content: none;
  }

  .cde .label-filter-star {
    display: block;
    user-select: none;
    cursor: pointer;
    margin-bottom: 10px;
    padding: 0;
  }

  .cde .label-filter-star input:checked+.checkbox {
    border-color: var(--bg-color);
  }

  .cde .label-filter-star input:checked+.checkbox svg path {
    fill: var(--bg-color);
  }

  .cde .label-filter-star input:checked+.checkbox svg polyline {
    stroke-dashoffset: 0;
  }

  .cde .label-filter-star:hover .checkbox svg path {
    stroke-dashoffset: 0;
  }

  .cde .label-filter-star .checkbox {
    position: relative;
    top: 2px;
    float: left;
    margin-bottom: 0;
    margin-right: 8px;
    width: 18px;
    height: 18px;
    border: 2px solid #C8CCD4;
    border-radius: 3px;
  }

  .cde .label-filter-star .checkbox svg {
    position: absolute;
    top: -2px;
    left: -2px;
  }

  .cde .label-filter-star .checkbox svg path {
    fill: none;
    stroke: var(--bg-color);
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
    stroke-dasharray: 71px;
    stroke-dashoffset: 71px;
    transition: all 0.6s ease;
  }

  .cde .label-filter-star .checkbox svg polyline {
    fill: none;
    stroke: #fff;
    stroke-width: 3;
    stroke-linecap: round;
    stroke-linejoin: round;
    stroke-dasharray: 18px;
    stroke-dashoffset: 18px;
    transition: all 0.3s ease;
  }

  .cde .invisible {
    position: absolute;
    z-index: -1;
    width: 0;
    height: 0;
    opacity: 0;
  }

  .cde label.label-filter-star .checkbox:before {
    content: none;
  }

  .cde #payFormCcard .content>div {
    padding: 15px 20px;
  }

  .cde .icheck {
    width: 20px;
    height: 20px;
  }

  .cde #payFormCcard .input-wrap:after {
    top: 2px;
  }

  .cde #payFormCcard .insurance-payment {
    background: #651d74;
    font-family: fontttc-li;
    width: 100%;
    height: 40px;
    font-size: 1.4em;
    border-radius: 5px;
  }

  @media screen and (min-width: 300px) and (max-width: 768px) {
    .cde #labelAgreeterm {
      font-size: 1.1em;
    }
  }

  @font-face {
    font-family: 'soap-icons';
    src: url("https://www.thaitravelcenter.com/template/theme/fonts/soap-icons.eot?26664784");
    src: url("https://www.thaitravelcenter.com/template/theme/fonts/soap-icons.eot?26664784#iefix") format("embedded-opentype"), url("https://www.thaitravelcenter.com/template/theme/fonts/soap-icons.woff2?26664784") format("woff2"), url("https://www.thaitravelcenter.com/template/theme/fonts/soap-icons.woff?26664784") format("woff"), url("https://www.thaitravelcenter.com/template/theme/fonts/soap-icons.ttf?26664784") format("truetype"), url("https://www.thaitravelcenter.com/template/theme/fonts/soap-icons.svg?26664784#soap-icons") format("svg");
    font-weight: normal;
    font-style: normal;
    font-display: swap;
  }

  @font-face {
    font-family: fontttc-bold;
    src: url('https://www.thaitravelcenter.com/template/theme/fonts/DBHeavent/DBHeaventMedv32.woff2');
    font-display: swap;
  }
</style>
<form class="cde">
  <!-- 
    <div class="form-group col-lg-12" style="margin-top: 15px; margin-bottom: 15px;">
    <label class="require" for="type">ประเภทบัตร : </label>
    <div class="col-sm-12 icheck-inline">
      <label style="display: inline;margin-right: 20px;">
        <input type="radio" name="pMethod" value="VISA" class="icheck" data-radio="iradio_square-red" required="" />
        <img style="cursor:pointer;" src="https://www.thaitravelcenter.com/travel-insurance/images/icons/payment-visa.png" alt="VISA" />
      </label>
      <label style="display: inline">
        <input type="radio" name="pMethod" value="Master" class="icheck" data-radio="iradio_square-red" required="" />
        <img style="cursor:pointer;" src="https://www.thaitravelcenter.com/travel-insurance/images/icons/payment-mastercard.png" alt="MasterCard" />
      </label>
    </div>
  </div> -->
  <div class="form-group col-lg-12" style="margin-top: 15px; margin-bottom: 15px;">
    <label class="required" for="cardNo1">หมายเลขบัตรเครดิต : </label>
    <div class="input-wrap">
      <input type="numberic" name="cardNo" id="cardNo" class="input-text full-width" maxlength="19" placeholder="XXXX XXXX XXXX XXXX" />
    </div>
    <div style="position: absolute;top: 35px;right: 27px;">
      <div height="20" class="components__VerticalSeparator-nsoutw-6 bcseSn ml-2">
        <img alt="none" width="24" height="24" class="components__Image-nsoutw-8 eoPsmY ml-2" src="https://assets.travizgo.com/production/web/common/payment-methods/credit-card-icons/visa.png" />
        <img alt="none" width="24" height="24" class="components__Image-nsoutw-8 eoPsmY ml-2" src="https://assets.travizgo.com/production/web/common/payment-methods/credit-card-icons/mastercard.png" />
      </div>
    </div>
  </div>

  <div class="form-group col-lg-4" style="margin-top: 15px; margin-bottom: 15px;">
    <label class="required" for="epMonth">เดือนหมดอายุ: </label>
    <div class="input-wrap">
      <select id="epMonth" class="input-text full-width titleSelect" style="text-indent: 0px;">
        <option value="">--</option>
        <option value="01">01</option>
        <option value="02">02</option>
        <option value="03">03</option>
        <option value="04">04</option>
        <option value="05">05</option>
        <option value="06">06</option>
        <option value="07">07</option>
        <option value="08">08</option>
        <option value="09">09</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
      </select>
    </div>
  </div>

  <div class="form-group col-lg-4" style="
    margin-top: 15px; margin-bottom: 15px;">
    <label class="required" for="epYear">ปีหมดอายุ: </label>
    <div class="input-wrap">
      <select name="epYear" id="epYear" class="input-text full-width titleSelect" style="text-indent: 0px;">
        <option value="">--</option>
        <?php for ($i = date("Y"); $i < (date("Y") + 30); $i++) : ?>
          <option value="<?= $i ?>"><?= $i ?></option>
        <?php endfor; ?>
      </select>
    </div>
  </div>

  <div class="form-group col-lg-4" style="
    margin-top: 15px; margin-bottom: 15px;">
    <label class="required" for="securityCode">CVV/CVC :</label>
    <div class="input-wrap">
      <input type="password" name="securityCode" id="securityCode" class="input-text full-width" placeholder="CVV/CVC" maxlength="4" />
    </div>
  </div>

  <div class="form-group col-lg-12" style="
    margin-top: 15px; margin-bottom: 15px;">
    <label class="required" for="cardHolder">ชื่อนามสกุล :</label>
    <div class="input-wrap">
      <input type="text" name="cardHolder" placeholder="ชื่อนามสกุลผู้ถือบัตรเครดิต" id="cardHolder" class="input-text full-width" />
    </div>
  </div>

  <label for="agreeterm" style="margin-left: 15px;" class="label-filter-star col-md-12 col-sm-4 col-xs-12" id="labelAgreeterm">
    <input id="agreeterm" name="terms" type="checkbox" value="0" class="invisible" />
    <div class="checkbox" style="min-height: 0;">
      <svg width="18px" height="18px" viewBox="0 0 20 20">
        <path d="M3,1 L17,1 L17,1 C18.1045695,1 19,1.8954305 19,3 L19,17 L19,17 C19,18.1045695 18.1045695,19 17,19 L3,19 L3,19 C1.8954305,19 1,18.1045695 1,17 L1,3 L1,3 C1,1.8954305 1.8954305,1 3,1 Z"></path>
        <polyline points="4 11 8 15 16 6"></polyline>
      </svg>
    </div>
    <span style="color:#6c6c6c">ยอมรับเงื่อนไข</span> <a href="<?= $data['termcondition_link'] ?>" target="_blank"><b>"ข้อตกลงและเงื่อนไขการชำระเงิน"</b></a>

  </label>

  <button type="submit" disabled="disabled" id="paymentFormBtn" style="padding:0px !important;height: 40px;width: 100%;margin-top: 15px;" class="insurance-payment btn">ชำระเงิน</button>

</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(document).on('keyup change', '.cde input,select', function() {
    var form = $("form.cde").serialize();
    console.log(form);
  })
</script>